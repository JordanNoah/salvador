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

use moodle_exception;
use stdClass;

/**
 * Utility class for all instance (module) routines helper.
 *
 * @package     local_digitalta
 * @copyright   2024 ADSDR-FUNIBER Scepter Team
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class GoogleMeetHelper
{

  /**
   * Wrapper function to perform an API call and also catch and handle potential exceptions.
   *
   * @param rest $service The rest API object
   * @param string $api The name of the API call
   * @param array $params The parameters required by the API call
   * @param string $rawpost Optional param to include in the body of a post.
   *
   * @return \stdClass The response object
   * @throws moodle_exception
   */
  public static function request($service, $api, $params, $rawpost = false): ?\stdClass
  {
    try {
      $response = $service->call($api, $params, $rawpost);
    } catch (\Exception $e) {
      if ($e->getCode() == 403 && strpos($e->getMessage(), 'Access Not Configured') !== false) {
        // This is raised when the Drive API service or the Calendar API service
        // has not been enabled on Google APIs control panel.
        throw new moodle_exception('servicenotenabled', 'local_digitalta');
      }
      throw $e;
    }

    return $response;
  }

  public static function get_googlemeet_record($chatid){
    global $DB;
    $record = $DB->get_record('digitalta_videomeetings', ['chatid' => $chatid]);
    return $record;
  }

  public static function save_googlemeet_record($chatid, $meetingcode){
    global $DB;
    $DB->delete_records('digitalta_videomeetings', ['chatid' => $chatid]);
    $record = new stdClass();
    $record->chatid = $chatid;
    $record->meetingcode = $meetingcode;
    $record->timecreated = time();
    $DB->insert_record('digitalta_videomeetings', $record);
  }

  public static function delete_googlemeet_record($chatid){
    global $DB;
    return $DB->delete_records('digitalta_videomeetings', ['chatid' => $chatid]);
  }
}
