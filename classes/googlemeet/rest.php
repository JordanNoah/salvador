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

/**
 * Google Rest API.
 *
 * @package     local_digitalta
 * @copyright   2024 ADSDR-FUNIBER Scepter Team
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_digitalta;


class GoogleMeetRest extends \core\oauth2\rest
{

  /**
   * Define the functions of the rest API.
   *
   * @return array
   */
  public function get_api_functions()
  {
    return [
      'createmeetingspace' => [
        'endpoint' => 'https://meet.googleapis.com/v2/spaces',
        'method' => 'post',
        'args' => [],
        'response' => 'json'
      ]
    ];
  }
}
