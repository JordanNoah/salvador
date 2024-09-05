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
 * WebService to assign resources
 *
 * @package   local_digitalta
 * @copyright 2024 ADSDR-FUNIBER Scepter Team
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/local/digitalta/classes/resources.php');

use local_digitalta\Resources;

/**
 * This class is used to assign resources
 *
 * @copyright 2024 ADSDR-FUNIBER Scepter Team
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class external_resources_assign extends external_api
{
    /**
     * Returns the description of the external function parameters
     *
     * @return external_function_parameters The external function parameters
     */
    public static function resources_assign_parameters()
    {
        return new external_function_parameters(
            [
                'resourceid' => new external_value(PARAM_INT, 'Resource identifier'),
                'component' => new external_value(PARAM_TEXT, 'Component'),
                'componentinstance' => new external_value(PARAM_INT, 'Component instance'),
                'description' => new external_value(PARAM_RAW, 'Description', VALUE_DEFAULT, "")
            ]
        );
    }

    /**
     * Assign resources
     *
     * @return array  Array of resources
     */
    public static function resources_assign($resourceid, $component, $componentinstance, $description)
    {
        // Get the resource
        $resource = Resources::get_resource($resourceid, false);

        // Check if the resource exists
        if (!$resource) {
            return [
                'result' => false,
                'error' => 'Resource not found',
            ];
        }

        // Check if the resource is already assigned
        $assigned = Resources::get_assignment($resourceid, $component, $componentinstance);

        // Check if the resource is already assigned
        if ($assigned) {
            return [
                'result' => false,
                'error' => 'Resource already assigned',
            ];
        }

        // Assign the resource
        $result = Resources::assign_resource($resourceid, $component, $componentinstance, $description);

        // Check if the resource was assigned
        if (!$result) {
            return [
                'result' => false,
                'error' => 'Resource not assigned',
            ];
        }

        // Return the result
        return [
            'result' => true,
            'id' => $result,
        ];
    }

    /**
     * Returns the description of the external function return value
     *
     * @return external_single_structure The external function return value
     */
    public static function resources_assign_returns()
    {
        return new external_single_structure(
            [
                'result' => new external_value(PARAM_BOOL, 'Result'),
                'id' => new external_value(PARAM_INT, 'Assignment identifier', VALUE_OPTIONAL),
                'error' => new external_value(PARAM_RAW, 'Error message' , VALUE_OPTIONAL)
            ]
        );
    }
}
