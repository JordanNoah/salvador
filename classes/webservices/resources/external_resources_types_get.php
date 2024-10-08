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
 * WebService to get resource types
 *
 * @package   local_digitalta
 * @copyright 2024 ADSDR-FUNIBER Scepter Team
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/local/digitalta/classes/resources.php');

use local_digitalta\Resources;

/**
 * This class is used to get resource types
 *
 * @copyright 2024 ADSDR-FUNIBER Scepter Team
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class external_resources_types_get extends external_api
{
    /**
     * Returns the description of the external function parameters
     *
     * @return external_function_parameters The external function parameters
     */
    public static function resources_types_get_parameters()
    {
        return new external_function_parameters(
            []
        );
    }

    /**
     * Get resource types
     *
     * @return array  Array of resource types
     */
    public static function resources_types_get()
    {
        if (!$types = Resources::get_types()) {
            return [
                'result' => false,
                'error' => 'No resource types found',
            ];
        }
        return [
            'result' => true,
            'types' => $types,
        ];
    }

    /**
     * Returns the description of the external function return value
     *
     * @return external_single_structure The external function return value
     */
    public static function resources_types_get_returns()
    {
        return new external_single_structure(
            [
                'result' => new external_value(PARAM_BOOL, 'Result'),
                'types' => new external_multiple_structure(
                    new external_single_structure(
                        [
                            'id' => new external_value(PARAM_INT, 'Type ID'),
                            'name' => new external_value(PARAM_TEXT, 'Type name')
                        ]
                    ), 'Resources', VALUE_OPTIONAL
                ),
                'error' => new external_value(PARAM_RAW, 'Error message' , VALUE_OPTIONAL)
            ]
        );
    }
}
