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
 * WebService to delete a section
 *
 * @package   local_digitalta
 * @copyright 2024 ADSDR-FUNIBER Scepter Team
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/local/digitalta/classes/sections.php');

use local_digitalta\Sections;

/**
 * This class is used to delete a section
 *
 * @copyright 2024 ADSDR-FUNIBER Scepter Team
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class external_sections_delete extends external_api
{
 
    /**
     * Returns the description of the external function parameters
     *
     * @return external_function_parameters The external function parameters
     */
    public static function sections_delete_parameters()
    {
        return new external_function_parameters(
            [
                'id' => new external_value(PARAM_INT, 'Section ID')
            ]
        );
    }

    /**
     * Deletes a section
     *
     * @param  int   $id Section ID
     * @return array The result of the operation
     */
    public static function sections_delete($id)
    {
        if (!Sections::get_section($id)) {
            return ['result' => false, 'error' => 'Section not found'];
        }
        if (!Sections::delete_section($id)) {
            return ['result' => false, 'error' => 'Error deleting section'];
        }
        return ['result' => true];
    }

    /**
     * Returns the description of the external function return value
     *
     * @return external_single_structure The external function return value
     */
    public static function sections_delete_returns()
    {
        return new external_single_structure(
            [
                'result' => new external_value(PARAM_BOOL, 'True if the section was deleted, false otherwise'),
                'error' => new external_value(PARAM_TEXT, 'Error message if there was an error', VALUE_OPTIONAL)
            ]
        );
    }
}