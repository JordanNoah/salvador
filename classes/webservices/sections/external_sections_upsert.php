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
 * WebService to upsert a section
 *
 * @package   local_digitalta
 * @copyright 2024 ADSDR-FUNIBER Scepter Team
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/local/digitalta/classes/components.php');
require_once($CFG->dirroot . '/local/digitalta/classes/sections.php');

use local_digitalta\Components;
use local_digitalta\Sections;

/**
 * This class is used to upsert a section
 *
 * @copyright 2024 ADSDR-FUNIBER Scepter Team
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class external_sections_upsert extends external_api
{
    /**
     * Returns the description of the external function parameters
     *
     * @return external_function_parameters The external function parameters
     */
    public static function sections_upsert_parameters()
    {
        return new external_function_parameters(
            [
                'id' => new external_value(PARAM_INT, 'Section ID', VALUE_OPTIONAL),
                'component' => new external_value(PARAM_TEXT, 'Component'),
                'componentinstance' => new external_value(PARAM_INT, 'Component instance'),
                'groupid' => new external_value(PARAM_INT, 'Group ID', VALUE_OPTIONAL),
                'groupname' => new external_value(PARAM_TEXT, 'Group', VALUE_OPTIONAL),
                'sequence' => new external_value(PARAM_INT, 'Sequence', VALUE_OPTIONAL),
                'type' => new external_value(PARAM_INT, 'Section type ID', VALUE_OPTIONAL),
                'typename' => new external_value(PARAM_TEXT, 'Section type', VALUE_OPTIONAL),
                'title' => new external_value(PARAM_TEXT, 'Title', VALUE_DEFAULT, ""),
                'content' => new external_value(PARAM_RAW, 'Content', VALUE_DEFAULT, "")
            ]
        );
    }

    /**
     * Upserts a section
     *
     * @param  int    $id                Section ID
     * @param  string $component         Component
     * @param  int    $componentinstance Component instance
     * @param  int    $groupid           Group ID
     * @param  string $groupname         Group
     * @param  int    $sequence          Sequence
     * @param  int    $type              Section type ID
     * @param  string $typename          Section type
     * @param  string $content           Content
     * @return array  The result of the operation
     */
    public static function sections_upsert($id = 0, $component, $componentinstance, $groupid = null, $groupname = null, $sequence = null, $type = null, $typename = null, $title = "", $content = "")
    {
        $section                    = new stdClass();
        $section->id                = $id;
        $section->component         = Components::get_component_by_name($component)->id;
        $section->componentinstance = $componentinstance;
        $section->sequence          = $sequence;
        $section->title             = $title;
        $section->content           = $content;

        if ($groupid) {
            $section->groupid = $groupid;
        } elseif ($groupname) {
            $section->groupid = Sections::get_group_by_name($groupname)->id;
        } else {
            return [
                'result' => false,
                'error' => 'Group or Group ID is required'
            ];
        }

        if ($type) {
            $section->type = $type;
        } elseif ($typename) {
            $section->type = Sections::get_type_by_name($typename)->id;
        } else {
            return [
                'result' => false,
                'error' => 'Type or Type ID is required'
            ];
        }

        if (!$sectionid = Sections::upsert_section($section)) {
            return [
                'result' => false,
                'error' => 'Error upserting section'
            ];
        }

        return [
            'result' => true,
            'sectionid' => $sectionid
        ];
    }

    /**
     * Returns the description of the external function returns
     *
     * @return external_single_structure The external function returns
     */
    public static function sections_upsert_returns()
    {
        return new external_single_structure(
            [
                'result' => new external_value(PARAM_BOOL, 'Result'),
                'sectionid' => new external_value(PARAM_INT, 'Section ID', VALUE_OPTIONAL),
                'error' => new external_value(PARAM_RAW, 'Error', VALUE_OPTIONAL)
            ]
        );
    }
}
