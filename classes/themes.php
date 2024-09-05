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
 * Themes class
 *
 * @package   local_digitalta
 * @copyright 2024 ADSDR-FUNIBER Scepter Team
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_digitalta;

require_once($CFG->dirroot . '/local/digitalta/classes/context.php');

use local_digitalta\Context;

use Exception;
use stdClass;

defined('MOODLE_INTERNAL') || die();

/**
 * This class is used to manage the themes of the plugin
 *
 * @copyright 2024 ADSDR-FUNIBER Scepter Team
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class Themes
{
    /** @var string The name of the database table storing the themes. */
    private static $table = 'digitalta_themes';

    /**
     * Get a theme by its ID.
     *
     * @param  int         $id The ID of the theme.
     * @return object|null The retrieved theme object.
     */
    public static function get_theme(int $id) : ?object
    {
        return self::get_themes(['id' => $id])[0] ?? null;
    }

    /**
     * Get all themes.
     *
     * @param  array $filters The filters to apply
     * @return array An array containing all themes.
     */
    public static function get_themes(array $filters = []): array
    {
        global $DB;
        $themes = $DB->get_records(self::$table, $filters);
        return array_values(array_map(function ($theme) {
            $theme->name = local_digitalta_get_element_translation('theme', $theme->name)[0];
            return $theme;
        }, $themes));
    }

    /**
     * Get all themes by text
     *
     * @param string $text
     * @return array
     */
    public static function get_themes_by_text($text): array
    {
        $themes = self::get_themes();
        if (empty($text)) {
            return $themes;
        }
        return array_values(array_filter($themes, function ($theme) use ($text) {
            return stripos($theme->name, $text) !== false;
        }));
    }

    /**
     * Check if a theme object is valid.
     *
     * @param  string $themename The theme to validate.
     * @return bool   True if the theme is valid, false otherwise.
     */
    public static function is_valid(string $themename): bool
    {
        if (empty($themename)) {
            return false;
        }   
        return true;
    }

    /**
     * Add a new theme.
     *
     * @param  string    $themename The theme to add.
     * @return int       The ID of the added theme.
     * @throws Exception If the theme is invalid.
     */
    public static function add_theme(string $themename): int
    {
        global $DB;
        if (!self::is_valid($themename)) {
            throw new Exception('Invalid theme name');
        }
        $theme = new stdClass();
        $theme->name = $themename;
        $theme->timecreated = time();
        $theme->timemodified = time();
        $themeid = $DB->insert_record(self::$table, $theme);
        return $themeid;
    }

    /**
     * Update an existing theme.
     *
     * @param  object    $theme The theme object to update.
     * @throws Exception If the theme is invalid.
     */
    public static function update_theme(object $theme): void
    {
        global $DB;
        if (!self::is_valid($theme->name)) {
            throw new Exception('Invalid theme name');
        }
        $theme->timemodefied = time();
        $DB->update_record(self::$table, $theme);
    }

    /**
     * Delete a theme by its ID.
     *
     * @param int $themeid The ID of the theme to delete.
     */
    public static function delete_theme(int $themeid): void
    {
        global $DB;
        $DB->delete_records(self::$table, ['id' => $themeid]);
    }

    /**
     * Assign a theme to a component
     *
     * @param  string $component The component to assign the theme to.
     * @param  int    $instance The instance of the component.
     * @param  int    $themeid The ID of the theme to assign.
     * @return bool
     */
    public static function assign_theme_to_component(string $component, int $instance, int $themeid) {
        return Context::insert_context($component, $instance, 'theme', $themeid);
    }

    /**
     * Get themes for a component
     *
     * @param  string    $component The component to get the themes for.
     * @param  int       $instance The instance of the component.
     * @return array
     * @throws Exception If the theme is invalid.
     */
    public static function get_themes_for_component(string $component, int $instance) {
        if (!$contexts = Context::get_contexts_by_component($component, $instance, 'theme')) {
            return [];
        }
        return array_map(function ($context) {
            if (!$theme = self::get_theme($context->modifierinstance)) {
                throw new Exception('Invalid theme');
            }
            return $theme;
        }, $contexts);
    }

    /**
     * Remove a theme from a component
     *
     * @param  string $component The component to remove the theme from.
     * @param  int    $instance The instance of the component.
     * @param  int    $themeid The ID of the theme to remove.
     * @return bool
     */
    public static function remove_theme_from_component(string $component, int $instance, int $themeid) {
        $context = Context::get_context_by_full_data($component, $instance, 'theme', $themeid);
        return Context::delete_context($context->id);
    }

    /**
     * Update themes for a component
     *
     * @param  string $component The component to update the themes for.
     * @param  int    $instance The instance of the component.
     * @param  array  $themes The themes to update.
     * @return void
     */
    public static function update_themes(string $component, int $instance, array $themes) {
        $current_themes = self::get_themes_for_component($component, $instance);
        $current_themes = array_map(function ($theme) {
            return $theme->id;
        }, $current_themes);
        foreach ($current_themes as $themeid) {
            if (!in_array($themeid, $themes)) {
                self::remove_theme_from_component($component, $instance, $themeid);
            }
        }
        foreach ($themes as $themeid) {
            if (!in_array($themeid, $current_themes)) {
                self::assign_theme_to_component($component, $instance, $themeid);
            }
        }
    }

}
