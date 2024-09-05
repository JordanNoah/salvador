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
 * WebService to toggle a report
 *
 * @package   local_digitalta
 * @copyright 2024 ADSDR-FUNIBER Scepter Team
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/local/digitalta/classes/components.php');
require_once($CFG->dirroot . '/local/digitalta/classes/reactions.php');

use local_digitalta\Components;
use local_digitalta\Reactions;

/**
 * This class is used to toggle a report
 *
 * @copyright 2024 ADSDR-FUNIBER Scepter Team
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class external_reactions_toggle_report extends external_api
{
    /**
     * Returns the description of the external function parameters
     *
     * @return external_function_parameters The external function parameters
     */
    public static function reactions_toggle_report_parameters()
    {
        return new external_function_parameters(
            [
                'component' => new external_value(PARAM_TEXT, 'Component'),
                'componentinstance' => new external_value(PARAM_INT, 'Component instance'),
                'description' => new external_value(PARAM_TEXT, 'Description', VALUE_DEFAULT, null)
            ]
        );
    }

    /**
     * Toggle a report
     *
     * @param  string $component The component
     * @param  int    $componentinstance The component instance
     * @param  string $description The description
     * @return array  The result of the operation
     */
    public static function reactions_toggle_report($component, $componentinstance, $description = null)
    {
        global $USER;

        $component = Components::get_component_by_name($component);
        $reaction = Reactions::toggle_report($component->id, $componentinstance, $description, $USER->id);
        if ($reaction === false) {
            return ['result' => false, 'error' => 'Could not toggle report'];
        }

        $reactiontype = ($reaction == -1) ? -1 : 1;

        return ['result' => true, 'reactiontype' => $reactiontype];
    }

    /**
     * Returns the description of the external function return value
     *
     * @return external_single_structure The external function return value
     */
    public static function reactions_toggle_report_returns()
    {
        return new external_single_structure(
            [
                'result' => new external_value(PARAM_BOOL, 'Result of the operation'),
                'reactiontype' => new external_value(PARAM_INT, '1 for report, -1 for unreport', VALUE_OPTIONAL),
                'error' => new external_value(PARAM_TEXT, 'Error message', VALUE_OPTIONAL)
            ]
        );
    }
}
