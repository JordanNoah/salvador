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
 * Context class
 *
 * @package   local_digitalta
 * @copyright 2024 ADSDR-FUNIBER Scepter Team
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_digitalta;

require_once($CFG->dirroot . '/local/digitalta/locallib.php');

use Exception;
use stdClass;

defined('MOODLE_INTERNAL') || die();

/**
 * This class is used to manage the contexts of the plugin
 *
 * @copyright 2024 ADSDR-FUNIBER Scepter Team
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class Context
{
    /** @var string The table name for the contexts. */
    private static $table = 'digitalta_context';

    /**
     * Check if a component or modifier is valid
     *
     * @param string $type The type of the context.
     * @param string $name The name of the context.
     * @return int|bool
     */
    public static function is_valid(string $type, string $name)
    {
        global $DB;
        if (!in_array($type, ['component', 'modifier'])) {
            throw new Exception('Invalid type');
        }
        $table = ($type == 'component') ? 'digitalta_components' : 'digitalta_modifiers';
        return $DB->get_field($table, 'id', ['name' => $name]);
    }

    /**
     * Get a context by its ID.
     *
     * @param  int         $id The ID of the context.
     * @return object|bool The retrieved context object.
     */
    public static function get_context(int $id)
    {
        global $DB;
        return $DB->get_record(self::$table, ['id' => $id]);
    }

    /**
     * Get a context by its full data.
     *
     * @param  string      $component The name of the component.
     * @param  int         $componentinstance The instance of the component.
     * @param  string      $modifier The name of the modifier.
     * @param  int         $modifierinstance The instance of the modifier.
     * @return object|bool
     */
    public static function get_context_by_full_data(string $component, int $componentinstance, string $modifier, int $modifierinstance)
    {
        global $DB;
        $componentid = self::is_valid('component', $component);
        $modifierid  = self::is_valid('modifier', $modifier);
        if (!$componentid || !$modifierid) {
            throw new Exception('Invalid component or modifier');
        }
        return $DB->get_record(self::$table,[
            'component'         => $componentid,
            'componentinstance' => $componentinstance,
            'modifier'          => $modifierid,
            'modifierinstance'  => $modifierinstance]);
    }

    /**
     * Get context by component.
     *
     * @param  string    $component The name of the component.
     * @param  int       $componentinstance The instance of the component.
     * @param  string    $modifier The name of the modifier.
     * @return array
     * @throws Exception If the component is invalid.
     */
    public static function get_contexts_by_component(string $component, int $componentinstance = null, string $modifier = null)
    {
        global $DB;
        $componentid = self::is_valid('component', $component);
        if (!$componentid) {
            throw new Exception('Invalid component');
        }
        $conditions = ['component' => $componentid];
        if ($componentinstance) {
            $conditions['componentinstance'] = $componentinstance;
        }
        if ($modifier) {
            $modifierid = self::is_valid('modifier', $modifier);
            if (!$modifierid) {
                throw new Exception('Invalid modifier');
            }
            $conditions['modifier'] = $modifierid;
        }
        return array_values($DB->get_records(self::$table, $conditions));
    }

    /**
     * Get context by modifier.
     *
     * @param  string    $modifier The name of the modifier.
     * @param  int       $modifierinstance The instance of the modifier.
     * @param  string    $component The name of the component.
     * @return array
     * @throws Exception If the modifier is invalid.
     */
    public static function get_contexts_by_modifier(string $modifier, int $modifierinstance = null, string $component = null)
    {
        global $DB;
        $modifierid = self::is_valid('modifier', $modifier);
        if (!$modifierid) {
            throw new Exception('Invalid modifier');
        }
        $conditions = ['modifier' => $modifierid];
        if ($modifierinstance) {
            $conditions['modifierinstance'] = $modifierinstance;
        }
        if ($component) {
            $componentid = self::is_valid('component', $component);
            if (!$componentid) {
                throw new Exception('Invalid component');
            }
            $conditions['component'] = $componentid;
        }
        return array_values($DB->get_records(self::$table, $conditions));
    }

    /**
     * Add a new context.
     *
     * @param  string    $component The name of the component.
     * @param  int       $componentinstance The instance of the component.
     * @param  string    $modifier The name of the modifier.
     * @param  int       $modifierinstance The instance of the modifier.
     * @return int       The ID of the added context.
     * @throws Exception If the component or modifier is invalid.
     */
    public static function insert_context(string $component, int $componentinstance, string $modifier, int $modifierinstance)
    {
        global $DB;
        if ($context = self::get_context_by_full_data($component, $componentinstance, $modifier, $modifierinstance)) {
            return $context->id;
        }
        $componentid = self::is_valid('component', $component);
        $modifierid  = self::is_valid('modifier', $modifier);
        if (!$componentid || !$modifierid) {
            throw new Exception('Invalid component or modifier');
        }
        $record                    = new stdClass();
        $record->component         = $componentid;
        $record->componentinstance = $componentinstance;
        $record->modifier          = $modifierid;
        $record->modifierinstance  = $modifierinstance;
        return $DB->insert_record(self::$table, $record);
    }

    /**
     * Delete a context
     *
     * @param  int  $id The ID of the context.
     * @return bool
     */
    public static function delete_context(int $id)
    {
        global $DB;
        return $DB->delete_records(self::$table, ['id' => $id]);
    }

    /**
     * Delete all contexts for a component
     *
     * @param  int $component The component identifier
     * @param  int $componentinstance The component instance identifier
     * @return bool
     * @throws Exception If the component is invalid.
     */
    public static function delete_all_contexts_for_component(int $component, int $componentinstance)
    {
        global $DB;
        $conditions = [
            'component' => $component,
            'componentinstance' => $componentinstance
        ];
        $DB->delete_records(self::$table, $conditions);
    }
}
