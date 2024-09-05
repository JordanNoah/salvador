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
 * WebService to create languages
 *
 * @package   local_digitalta
 * @copyright 2024 ADSDR-FUNIBER Scepter Team
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/local/digitalta/classes/languages.php');

use local_digitalta\Languages;

/**
 * This class is used to create languages
 *
 * @copyright 2024 ADSDR-FUNIBER Scepter Team
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class external_languages_get extends external_api
{

    /**
     * Returns the description of the external function parameters
     *
     * @return external_function_parameters The external function parameters
     */
    public static function languages_get_parameters()
    {
        return new external_function_parameters(
            [
                'prioritizeInstalled' => new external_value(PARAM_BOOL, 'Prioritize installed', VALUE_DEFAULT, false)
            ]
        );
    }

    /**
     * Get languages
     *
     * @param  bool  Prioritize installed
     * @return array Array of languages
     */
    public static function languages_get($prioritizeInstalled = false)
    {
        return Languages::get_all_languages($prioritizeInstalled) ?? [];
    }

    /**
     * Returns the description of the external function return value
     *
     * @return external_single_structure The external function return value
     */
    public static function languages_get_returns()
    {
        return new external_multiple_structure(
            new external_single_structure(
                array(
                    'code' => new external_value(PARAM_TEXT, 'Language code'),
                    'name' => new external_value(PARAM_TEXT, 'Language name')
                )
            )
        );
    }
}
