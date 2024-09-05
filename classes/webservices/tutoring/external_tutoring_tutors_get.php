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
 * WebService to get tutors
 *
 * @package   local_digitalta
 * @copyright 2024 ADSDR-FUNIBER Scepter Team
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

use local_digitalta\Tutors;

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/local/digitalta/classes/tutors.php');
/**
 * This class is used to create tags
 *
 * @copyright 2024 ADSDR-FUNIBER Scepter Team
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class external_tutoring_tutors_get extends external_api
{

    public static function tutors_get_parameters()
    {
        return new external_function_parameters(
            [
                'searchText' => new external_value(PARAM_TEXT, 'Search text', VALUE_DEFAULT, '%%'),
                'experienceid' => new external_value(PARAM_INT, 'Experience id', VALUE_DEFAULT, 0)
            ]
        );
    }

    public static function tutors_get($searchText = '%%', $experienceid  = 0)
    {
        global $DB, $PAGE, $USER;
        $PAGE->set_context(context_system::instance());
        $searchText = '%' . trim($searchText) . '%';

        if ($DB->sql_regex_supported()) {
            $fullname = $DB->sql_concat('firstname', "' '", 'lastname');
        } else {
            $fullname = "CONCAT(firstname, ' ', lastname)";
        }

        $likeFullname = $DB->sql_like($fullname, ':fullname', false);
        $sql = "SELECT * FROM {user} WHERE {$likeFullname}";
        $tutors = $DB->get_records_sql($sql, ['fullname' => $searchText]);
        
        $tutors = array_filter($tutors, function ($tutor) use ($USER) {
            return $tutor->id != $USER->id;
        });

        $tutors = array_filter($tutors, function ($tutor) use ($experienceid){
            return !Tutors::is_enrolled_tutor_in_course($tutor->id, $experienceid, 1);
        });

        foreach ($tutors as $tutor) {
            $tutor->isEnrolled = Tutors::is_enrolled_tutor_in_course($tutor->id, $experienceid, 0);
        }

        $tutors = array_map(function ($tutor) use ($PAGE) {
            $tutor_picture = new user_picture($tutor);
            $tutor_picture->size = 101;
            return [
                'id' => $tutor->id,
                'name' => $tutor->firstname . ' ' . $tutor->lastname,
                'isEnrolled' => $tutor->isEnrolled,
                'profileimage' => $tutor_picture->get_url($PAGE)->__toString(),
                'university' => "Universidad de la vida",
            ];
        }, $tutors);

        return $tutors;
    }

    public static function tutors_get_returns()
    {
        return new external_multiple_structure(
            new external_single_structure(
                array(
                    'id' => new external_value(PARAM_INT, 'Tutor id'),
                    'name' => new external_value(PARAM_TEXT, 'Tutor firstname'),
                    'isEnrolled' => new external_value(PARAM_BOOL, 'Is enrolled in the experience'),
                    'profileimage' => new external_value(PARAM_TEXT, 'Profile image'),
                    'university' => new external_value(PARAM_TEXT, 'University'),
                )
            )
        );
    }
}
