<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.


namespace local_digitalta;

require_once($CFG->dirroot . '/local/digitalta/classes/googlemeet/helper.php');
require_once($CFG->dirroot . '/local/digitalta/classes/googlemeet/rest.php');

use local_digitalta\GoogleMeetHelper;
use local_digitalta\GoogleMeetRest;

use moodle_url;
use html_writer;
use dml_missing_record_exception;
use moodle_exception;

class GoogleMeetClient
{

  /**
   * OAuth 2 client
   * @var \core\oauth2\client
   */
  private $client = null;

  /**
   * OAuth 2 Issuer
   * @var \core\oauth2\issuer
   */
  private $issuer = null;

  /** @var bool informs if the client is enabled */
  public $enabled = true;

  /**
   * Additional scopes required for drive.
   */
  const SCOPES = 'https://www.googleapis.com/auth/meetings.space.readonly https://www.googleapis.com/auth/meetings.space.created';

  /**
   * Constructor.
   *
   * @return void
   */
  public function __construct($chatid=null)
  {
    try {
      $this->issuer = \core\oauth2\api::get_issuer(get_config('local_digitalta', 'issuerid'));
    } catch (dml_missing_record_exception $e) {
      $this->enabled = false;
    }

    if ($this->issuer && (!$this->issuer->get('enabled') || $this->issuer->get('id') == 0)) {
      $this->enabled = false;
    }

    $client = $this->get_user_oauth_client($chatid);
    if ($this->enabled && $client->get_login_url()->get_host() !== 'accounts.google.com') {
      throw new moodle_exception('invalidissuerid', 'local_digitalta');
    }
  }

  /**
   * Get a cached user authenticated oauth client.
   *
   * @return \core\oauth2\client
   */
  protected function get_user_oauth_client($chatid = null)
  {
    if ($this->client) {
      return $this->client;
    }

    $returnurl = new moodle_url('/local/digitalta/classes/googlemeet/callback.php');
    $returnurl->param('callback', 'yes');
    $returnurl->param('sesskey', sesskey());
    if($chatid){
      $returnurl->param('chatid', $chatid);
    }
    $this->client = \core\oauth2\api::get_user_oauth_client($this->issuer, $returnurl, self::SCOPES, true);

    return $this->client;
  }

  /**
   * Print the login in a popup.
   *
   * @param array|null $attr Custom attributes to be applied to popup div.
   *
   * @return string HTML code
   */
  public function print_login_popup($chatid = null)
  {
    global $OUTPUT;

    $client = $this->get_user_oauth_client($chatid);
    $url = new moodle_url($client->get_login_url());
    $state = $url->get_param('state') . '&reloadparent=true';
    $url->param('state', $state);

    return html_writer::div('
          <button class="btn btn-zoom-call" onClick="javascript:window.open(\'' . $client->get_login_url() . '\',
              \'Login\',\'height=600,width=599,top=0,left=0,menubar=0,location=0,directories=0,fullscreen=0\'
          ); return false"><i class="fa fa-video-camera"></i> ' . get_string('tutoring:videocallbutton', 'local_digitalta') . '</button>', 'mt-2');
  }

  /**
   * Print user info.
   *
   * @param string|null $scope 'calendar' or 'drive' Defines which link will be used.
   *
   * @return string HTML code
   */
  public function print_user_info()
  {
    global $OUTPUT, $PAGE;

    if (!$this->check_login()) {
      return '';
    }

    $userauth = $this->get_user_oauth_client();
    $userinfo = $userauth->get_userinfo();

    $username = $userinfo['username'];
    $name = $userinfo['firstname'] . ' ' . $userinfo['lastname'];
    $userpicture = base64_encode($userinfo['picture']);

    $userurl = new moodle_url('https://google.com/');

    $logouturl = new moodle_url($PAGE->url);
    $logouturl->param('logout', true);

    $img = html_writer::img('data:image/jpeg;base64,' . $userpicture, '');
    $out = html_writer::start_div('', ['id' => 'googlemeet_auth-info']);
    $out .= html_writer::link(
      $userurl,
      $img,
      ['id' => 'googlemeet_picture-user', 'target' => '_blank', 'title' => get_string('manage', 'googlemeet')]
    );
    $out .= html_writer::start_div('', ['id' => 'googlemeet_user-name']);
    $out .= html_writer::span(get_string('loggedinaccount', 'googlemeet'), '');
    $out .= html_writer::span($name);
    $out .= html_writer::span($username);
    $out .= html_writer::end_div();
    $out .= html_writer::link(
      $logouturl,
      $OUTPUT->pix_icon('logout', '', 'googlemeet', ['class' => 'm-0']),
      ['class' => 'btn btn-secondary btn-sm', 'title' => get_string('logout', 'googlemeet')]
    );

    $out .= html_writer::end_div();

    return $out;
  }

  /**
   * Checks whether the user is authenticate or not.
   *
   * @return bool true when logged in.
   */
  public function check_login()
  {
    $client = $this->get_user_oauth_client();
    return $client->is_logged_in();
  }

  /**
   * Logout.
   *
   * @return void
   */
  public function logout()
  {
    global $PAGE;

    if ($this->check_login()) {
      $url = new moodle_url($PAGE->url);
      $client = $this->get_user_oauth_client();
      $client->log_out();
      $js = <<<EOD
              <html>
              <head>
                  <script type="text/javascript">
                      window.location = '{$url}'.replaceAll('&amp;','&')
                  </script>
              </head>
              <body></body>
              </html>
          EOD;
      die($js);
    }
  }

  /**
   * Store the access token.
   *
   * @return string|null The meeting space URI
   */
  public function callback($chatid)
  {
    $client = $this->get_user_oauth_client();

    if($this->check_login()){
      $response = $this->create_meeting_space();
      if($response->meetingUri){
        if($chatid){
          GoogleMeetHelper::save_googlemeet_record($chatid, $response->meetingCode);
        }
        return $response->meetingUri;
      }
    }
    return null;
    // This will upgrade to an access token if we have an authorization code and save the access token in the session.
    //$client->is_logged_in();
  }

  public function create_meeting_space()
  {
    if ($this->check_login()) {
      $service = new GoogleMeetRest($this->get_user_oauth_client());

      $response = GoogleMeetHelper::request($service, 'createmeetingspace', [], false);

      return $response;
    }
  }

  /**
   * Get the email of the logged in Google account
   *
   * @return string The email
   */
  public function get_email()
  {
    if (!$this->check_login()) {
      return '';
    }

    $userauth = $this->get_user_oauth_client()->get_userinfo();
    return $userauth['username'];
  }
}
