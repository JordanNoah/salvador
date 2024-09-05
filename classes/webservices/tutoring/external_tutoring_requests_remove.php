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
 * WebService to remove tutors requests
 *
 * @package   local_digitalta
 * @copyright 2024 ADSDR-FUNIBER Scepter Team
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/local/digitalta/classes/tags.php');
require_once($CFG->dirroot . '/local/digitalta/classes/tutors.php');

use local_digitalta\Tutors;

/**
 * 
 *
 * @copyright 2024 ADSDR-FUNIBER Scepter Team
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class external_tutoring_requests_remove extends external_api
{

    public static function requests_remove_parameters()
    {
        return new external_function_parameters(
            [
                'tutorid' => new external_value(PARAM_INT, 'Tutor id'),
                'experienceid' => new external_value(PARAM_INT, 'Experience id'),
            ]
        );
    }

    public static function requests_remove($tutorid, $experienceid)
    {
        Tutors::requests_remove($tutorid, $experienceid);
        return [
            'success' => true
        ];
    }

    public static function requests_remove_returns()
    {
        return
            new external_single_structure(
                [
                    'success' => new external_value(PARAM_BOOL, 'Success')
                ]
            );
    }
}
