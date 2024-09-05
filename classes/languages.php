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
 * Languages class
 *
 * @package   local_digitalta
 * @copyright 2024 ADSDR-FUNIBER Scepter Team
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_digitalta;

defined('MOODLE_INTERNAL') || die();

/**
 * This class is used to manage the languages of the plugin
 *
 * @copyright 2024 ADSDR-FUNIBER Scepter Team
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class Languages
{
    /**
     * Get all the languages
     *
     * @param  bool  $prioritize_installed Whether to prioritize the installed languages
     * @return array
     */
    public static function get_all_languages(bool $prioritize_installed = false)
    {
        $languages = get_string_manager()->get_list_of_languages();
        $languages['pluri'] = get_string('general:lang_pluri', 'local_digitalta');
        asort($languages);
        if ($prioritize_installed) {
            $prioritized_languages = [];
            // Add the current language first
            $current_language = current_language();
            $prioritized_languages[$current_language] = $languages[$current_language];
            // Add the plurilingual value
            $prioritized_languages['pluri'] = $languages['pluri'];
            // Add the installed languages
            $installed_languages = get_string_manager()->get_list_of_translations();
            $installed_languages = array_intersect_key($languages, $installed_languages);
            $prioritized_languages = array_merge($prioritized_languages,
                array_diff_key($installed_languages, $prioritized_languages));
            // Add the rest of the languages
            $languages = array_merge($prioritized_languages,
                array_diff_key($languages, $prioritized_languages));
        }
        return array_values(array_map(function ($name, $code) {
            return (object) ['code' => $code, 'name' => $name];
        }, $languages, array_keys($languages)));
    }

    /**
     * Get the language name by code
     *
     * @param  string $code The language code
     * @return string The language name
     */
    public static function get_language_name_by_code(string $code)
    {
        return ($code === 'pluri')
            ? get_string('general:lang_pluri', 'local_digitalta')
            : get_string_manager()->get_list_of_languages()[$code] ?? '';
    }
}
