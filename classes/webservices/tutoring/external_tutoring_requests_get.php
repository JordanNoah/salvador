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
class external_tutoring_requests_get extends external_api
{

    public static function requests_get_parameters()
    {
        return new external_function_parameters(
            [
                'experienceid' => new external_value(PARAM_INT, 'Experience id', VALUE_DEFAULT, 0),
            ]
        );
    }

    public static function requests_get($experienceid = 0)
    {
        global $DB, $PAGE, $USER;
        $PAGE->set_context(context_system::instance());
        if($experienceid == 0) {
            $tutors = Tutors::requests_get_by_tutor($USER->id);
        }else{
            $tutors = Tutors::requests_get_by_experience($experienceid);
        }

        if (count($tutors) == 0) {
            return [
                'total' => 0,
                'requests' => []
            ];
        }

        $tutors = array_map(function ($tutor) use ($DB, $PAGE) {
            $tutor_info = $DB->get_record('user', ['id' => $tutor->tutorid]);
            $tutor_picture = new user_picture($tutor_info);
            $tutor_picture->size = 101;
            return [
                'requestid' => $tutor->id,
                'userid' => $tutor_info->id,
                'firstname' => $tutor_info->firstname,
                'lastname' => $tutor_info->lastname,
                'profileimageurl' => $tutor_picture->get_url($PAGE)->__toString()
            ];
        }, $tutors);
        return [
            'total' => count($tutors),
            'requests' => $tutors
        ];
    }

    public static function requests_get_returns()
    {
        return
            new external_single_structure(
                [
                    'total' => new external_value(PARAM_INT, 'Total tutors requests', VALUE_DEFAULT, 0),
                    'requests' => new external_multiple_structure(
                        new external_single_structure(
                            [
                                'requestid' => new external_value(PARAM_INT, 'Tutor request id'),
                                'userid' => new external_value(PARAM_INT, 'Tutor id'),
                                'firstname' => new external_value(PARAM_TEXT, 'Tutor firstname'),
                                'lastname' => new external_value(PARAM_TEXT, 'Tutor lastname'),
                                'profileimageurl' => new external_value(PARAM_URL, 'Tutor profile image url')
                            ]
                        ),
                        VALUE_DEFAULT,
                        []
                    )
                ]
            );
    }
}
