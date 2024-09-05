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
 * WebService to upsert an experience
 *
 * @package   local_digitalta
 * @copyright 2024 ADSDR-FUNIBER Scepter Team
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/local/digitalta/classes/experiences.php');

use local_digitalta\Experiences;

/**
 * This class is used to upsert an experience
 *
 * @copyright 2024 ADSDR-FUNIBER Scepter Team
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class external_experiences_upsert extends external_api
{
    /**
     * Returns the description of the external function parameters
     *
     * @return external_function_parameters The external function parameters
     */
    public static function experiences_upsert_parameters()
    {
        return new external_function_parameters(
            [
                'id' => new external_value(PARAM_INT, 'Experience ID', VALUE_DEFAULT, 0),
                'title' => new external_value(PARAM_TEXT, 'Title'),
                'lang' => new external_value(PARAM_TEXT, 'Lang'),
                'visible' => new external_value(PARAM_INT, 'Visible', VALUE_DEFAULT, 1),
                'status' => new external_value(PARAM_INT, 'Status' , VALUE_DEFAULT, 0),
                'sections' => new external_multiple_structure(
                    new external_single_structure(
                        [
                            'id' => new external_value(PARAM_INT, 'Section ID', VALUE_OPTIONAL),
                            'component' => new external_value(PARAM_INT, 'Component ID', VALUE_OPTIONAL),
                            'componentinstance' => new external_value(PARAM_INT, 'Component Instance ID', VALUE_OPTIONAL),
                            'groupid' => new external_value(PARAM_INT, 'Group ID', VALUE_OPTIONAL),
                            'groupname' => new external_value(PARAM_TEXT, 'Group Name', VALUE_OPTIONAL),
                            'sequence' => new external_value(PARAM_INT, 'Sequence', VALUE_OPTIONAL),
                            'type' =>  new external_value(PARAM_TEXT, 'Section type', VALUE_OPTIONAL),
                            'typename' =>  new external_value(PARAM_TEXT, 'Section type name', VALUE_OPTIONAL),
                            'content' => new external_value(PARAM_RAW, 'Content', VALUE_DEFAULT, "")
                        ]
                    ), 'Sections' , VALUE_DEFAULT, []
                ),
                'themes' => new external_multiple_structure(
                    new external_value(PARAM_INT, 'Theme ID'), 'Themes' , VALUE_DEFAULT, []
                ),
                'tags' => new external_multiple_structure(
                    new external_value(PARAM_INT, 'Tag ID'), 'Tags' , VALUE_DEFAULT, []
                )
            ]
        );
    }

    /**
     * Upserts an experience
     *
     * @param  int    $id          Experience ID
     * @param  string $title       Title
     * @param  string $lang        Lang
     * @param  int    $visible     Visible
     * @param  int    $status      Status
     * @param  array  $sections    Sections
     * @param  array  $themes      Themes
     * @param  array  $tags        Tags
     * @return array  The result of the operation
     */
    public static function experiences_upsert($id = 0, $title, $lang, $visible = 1, $status = 0 , $sections = [], $themes = [], $tags = [])
    {
        $experience           = new stdClass();
        $experience->id       = $id;
        $experience->title    = $title;
        $experience->lang     = $lang;
        $experience->visible  = $visible;
        $experience->status   = $status;
        $experience->sections = $sections;
        $experience->themes   = $themes;
        $experience->tags     = $tags;

        if(!$experienceid = Experiences::upsert_experience($experience)) {
            return [
                'result' => false,
                'error' => 'Error saving experience'
            ];
        }

        return [
            'result' => true,
            'experienceid' => $experienceid
        ];
    }

    /**
     * Returns the description of the external function returns
     *
     * @return external_single_structure The external function returns
     */
    public static function experiences_upsert_returns()
    {
        return new external_single_structure(
            [
                'result' => new external_value(PARAM_BOOL, 'Result'),
                'experienceid' => new external_value(PARAM_INT, 'Experience ID' , VALUE_OPTIONAL),
                'error' => new external_value(PARAM_RAW, 'Error message' , VALUE_OPTIONAL),
            ]
        );
    }
}
