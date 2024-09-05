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
 * Components class
 *
 * @package   local_digitalta
 * @copyright 2024 ADSDR-FUNIBER Scepter Team
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_digitalta;

require_once($CFG->dirroot . '/local/digitalta/locallib.php');

defined('MOODLE_INTERNAL') || die();

/**
 * This class is used to manage the components of the plugin
 *
 * @copyright 2024 ADSDR-FUNIBER Scepter Team
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class Components
{
    /** @var string The table name for the components. */
    private static $table = 'digitalta_components';

    /**
     * Get the component by its id
     *
     * @param  int         $id The ID of the component
     * @return object|null The component
     */
    public static function get_component(int $id): ?object
    {
        return self::get_components(['id' => $id])[0] ?? null;
    }

    /**
     * Get the component by name
     *
     * @param  string      $name The component name
     * @return object|null The component
     */
    public static function get_component_by_name(string $name): ?object
    {
        return self::get_components(['name' => $name])[0] ?? null;
    }

    /**
     * Get components
     *
     * @param  array $filters The filters to apply
     * @return array The components
     */
    public static function get_components(array $filters = [])
    {
        global $DB;
        return array_values($DB->get_records(self::$table, $filters));
    }

    /**
     * Get the database record of an instance of a component
     *
     * @param  string      $component   The component name
     * @param  int         $instanceid  The instance identifier
     * @return object|null The instance record
     */
    public static function get_instance_record(string $component, int $instanceid)
    {
        global $DB;

        $dbman = $DB->get_manager();

        if ($dbman->table_exists('digitalta_' . $component)) {
            return $DB->get_record('digitalta_' . $component, ['id' => $instanceid]);
        } elseif ($dbman->table_exists('digitalta_' . $component . 's')) {
            return $DB->get_record('digitalta_' . $component . 's', ['id' => $instanceid]);
        } elseif ($dbman->table_exists('mdl_' . $component)) {
            return $DB->get_record('mdl_' . $component, ['id' => $instanceid]);
        } else {
            return null;
        }
    }
}
