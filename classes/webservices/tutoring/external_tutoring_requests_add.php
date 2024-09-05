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
 * WebService to get tutors requests
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
 * This class is used to create tags
 *
 * @copyright 2024 ADSDR-FUNIBER Scepter Team
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class external_tutoring_requests_add extends external_api
{

    public static function requests_add_parameters()
    {
        return new external_function_parameters(
            [
                'tutorid' => new external_value(PARAM_INT, 'Tutor id'),
                'experienceid' => new external_value(PARAM_INT, 'Experience id'),
            ]
        );
    }

    public static function requests_add($tutorid, $experienceid)
    {
        Tutors::send_tutor_request($tutorid, $experienceid);
        return [
            'success' => true
        ];
    }

    public static function requests_add_returns()
    {
        return
            new external_single_structure(
                [
                    'success' => new external_value(PARAM_BOOL, 'Success')
                ]
            );
    }
}
