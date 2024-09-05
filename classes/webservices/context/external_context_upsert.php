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
 * WebService to insert a context
 *
 * @package   local_digitalta
 * @copyright 2024 ADSDR-FUNIBER Scepter Team
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/local/digitalta/classes/context.php');

use local_digitalta\Context;

/**
 * This class is used to insert a context
 *
 * @copyright 2024 ADSDR-FUNIBER Scepter Team
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class external_context_upsert extends external_api
{

    public static function context_upsert_parameters()
    {
        return new external_function_parameters(
            array(
                'component' => new external_value(PARAM_TEXT, 'Component'),
                'componentinstance' => new external_value(PARAM_INT, 'Component instance'),
                'modifier' => new external_value(PARAM_TEXT, 'Modifier'),
                'modifierinstance' => new external_value(PARAM_INT, 'Modifier instance'),
            )
        );
    }

    public static function context_upsert($component, $componentinstance, $modifier, $modifierinstance)
    {
        global $USER;

        if(!$contextId = Context::insert_context($component, $componentinstance, $modifier, $modifierinstance)){
            return [
                'result' => false,
                'error' => 'Error saving context'
            ];
        }

        return [
            'result' => true,
            'contextid' => $contextId
        ];
    }

    public static function context_upsert_returns()
    {
        return new external_single_structure(
            [
                'result' => new external_value(PARAM_BOOL, 'Result'),
                'contextid' => new external_value(PARAM_INT, 'Section ID' , VALUE_OPTIONAL),
                'error' => new external_value(PARAM_RAW, 'Error message' , VALUE_OPTIONAL),
            ]
        );
    }
}
