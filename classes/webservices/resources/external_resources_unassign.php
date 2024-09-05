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
 * WebService to unasign resources
 *
 * @package   local_digitalta
 * @copyright 2024 ADSDR-FUNIBER Scepter Team
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/local/digitalta/classes/resources.php');

use local_digitalta\Resources;

/**
 * This class is used to unassign resources
 *
 * @copyright 2024 ADSDR-FUNIBER Scepter Team
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class external_resources_unassign extends external_api
{
    /**
     * Returns the description of the external function parameters
     *
     * @return external_function_parameters The external function parameters
     */
    public static function resources_unassign_parameters()
    {
        return new external_function_parameters(
            [
                'id' => new external_value(PARAM_INT, 'Resource identifier'),
                'component' => new external_value(PARAM_TEXT, 'Component'),
                'componentinstance' => new external_value(PARAM_INT, 'Component instance')
            ]
        );
    }

    /**
     * Unassign resources
     *
     * @return array  Array of resources
     */
    public static function resources_unassign($id, $component, $componentinstance)
    {
        // Get the assignment
        $assignment = Resources::get_assignment($id, $component, $componentinstance);

        // Check if the assignment exists
        if (!$assignment) {
            return [
                'result' => false,
                'error' => 'Assignment not found',
            ];
        }

        // Unassign the resource
        $result = Resources::unassign_resource($assignment->id);

        // Check if the resource was unassigned
        if (!$result) {
            return [
                'result' => false,
                'error' => 'Resource not unassigned',
            ];
        }

        // Return the result
        return [ 'result' => true ];
    }

    /**
     * Returns the description of the external function return value
     *
     * @return external_single_structure The external function return value
     */
    public static function resources_unassign_returns()
    {
        return new external_single_structure(
            [
                'result' => new external_value(PARAM_BOOL, 'Result'),
                'error' => new external_value(PARAM_RAW, 'Error message' , VALUE_OPTIONAL)
            ]
        );
    }
}
