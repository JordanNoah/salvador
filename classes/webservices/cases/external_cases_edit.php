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
 * WebService to edit cases
 *
 * @package   local_digitalta
 * @copyright 2024 ADSDR-FUNIBER Scepter Team
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/local/digitalta/classes/cases.php');

use local_digitalta\Cases;

/**
 * This class is used to edit cases
 *
 * @copyright 2024 ADSDR-FUNIBER Scepter Team
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class external_cases_edit extends external_api
{
 
    /**
     * Returns the description of the external function parameters
     *
     * @return external_function_parameters The external function parameters
     */
    public static function cases_edit_parameters()
    {
        return new external_function_parameters(
            array(
                'id' => new external_value(PARAM_INT, 'Case ID'),
                'title' => new external_value(PARAM_TEXT, 'Title'),
                'description' => new external_value(PARAM_RAW, 'Description'),
                'lang' => new external_value(PARAM_TEXT, 'Language'),
                'status' => new external_value(PARAM_INT, 'Status', VALUE_DEFAULT, 0),
                'themes' => new external_multiple_structure(
                    new external_value(PARAM_INT, 'ID del elemento'), 'Themes' , VALUE_DEFAULT, []
                ),
                'tags' => new external_multiple_structure(
                    new external_value(PARAM_INT, 'ID del elemento'), 'Tags' , VALUE_DEFAULT, []
                )
            )
        );
    }

    /**
     * Edit a case
     *
     * @param  int    $id The case identifier
     * @param  string $title The case title
     * @param  string $description The case description
     * @param  string $lang The case language
     * @param  int    $status The case status
     * @param  array  $themes The case themes
     * @param  array  $tags The case tags
     * @return array  The result of the operation
     */
    public static function cases_edit($id, $title, $description = "", $lang, $status = 0, $themes = [], $tags = [])
    {
        if (!Cases::get_case($id, false)) {
            return ['result' => false, 'error' => 'Case not found'];
        }

        $newcase = new stdClass();
        $newcase->id          = $id;
        $newcase->title       = $title;
        $newcase->description = $description;
        $newcase->lang        = $lang;
        $newcase->status      = $status;
        $newcase->themes      = $themes;
        $newcase->tags        = $tags;

        if (!$caseid = Cases::update_case($newcase)) {
            return [
                'result' => false,
                'error' => 'Failed to update case'
            ];
        }

        return [
            'result' => true,
            'caseid' => $caseid
        ];
    }

    /**
     * Returns the description of the external function returns
     *
     * @return external_single_structure The external function returns
     */
    public static function cases_edit_returns()
    {
        return new external_single_structure(
            array(
                'result' => new external_value(PARAM_BOOL, 'True if success, false otherwise' , VALUE_OPTIONAL),
                'caseid' => new external_value(PARAM_INT, 'Case ID' , VALUE_OPTIONAL),
                'error' => new external_value(PARAM_TEXT, 'Error message if any' , VALUE_OPTIONAL)
            )
        );
    }
}
