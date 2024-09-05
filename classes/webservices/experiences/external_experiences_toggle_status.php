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
 * WebService to toggle the status of an experience
 *
 * @package   local_digitalta
 * @copyright 2024 ADSDR-FUNIBER Scepter Team
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/local/digitalta/classes/context.php');
require_once($CFG->dirroot . '/local/digitalta/classes/experiences.php');

use local_digitalta\Experiences;

/**
 * This class is used to toggle the status of an experience
 *
 * @copyright 2024 ADSDR-FUNIBER Scepter Team
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class external_experiences_toggle_status extends external_api
{
    /**
     * Returns the description of the external function parameters
     *
     * @return external_function_parameters The external function parameters
     */
    public static function experiences_toggle_status_parameters()
    {
        return new external_function_parameters(
            [
                'id' => new external_value(PARAM_INT, 'experience ID'),
            ]
        );
    }

    /**
     * Toggles the status of an experience
     *
     * @param  int   $id Experience ID
     * @return array The result of the operation
     */
    public static function experiences_toggle_status($id)
    {
        return [
            'result' => true,
            'status' => Experiences::toggle_status($id),
        ];
    }

    /**
     * Returns the description of the external function returns
     *
     * @return external_single_structure The external function returns
     */
    public static function experiences_toggle_status_returns()
    {
        return new external_single_structure(
            [
                'result' => new external_value(PARAM_BOOL, 'Result'),
                'status' => new external_value(PARAM_INT, 'Section ID'),
            ]
        );
    }
}
