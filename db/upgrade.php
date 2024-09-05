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
 *  Upgrade steps for the local_digitalta plugin.
 *
 * @package    local_digitalta
 * @copyright  2024 ADSDR-FUNIBER Scepter Team
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/local/digitalta/locallib.php');

/**
 * Upgrade the local_digitalta plugin.
 *
 * @param int $oldversion The version we are upgrading from.
 * @return bool
 */
function xmldb_local_digitalta_upgrade($oldversion)
{
    global $DB;

    $dbman = $DB->get_manager();

    if ($oldversion < 2024060200) {
        throw new Exception('The version is too old. Continuing the upgrade process is not possible. Please, reinstall the plugin. Keep in mind that you will lose all the data.');
    }

    // Try all insertions regardless of the version
    // Insert the components
    $table = new xmldb_table('digitalta_components');
    if ($dbman->table_exists($table)) {
        foreach (LOCAL_DIGITALTA_COMPONENTS as $value) {
            if ($DB->record_exists('digitalta_components', ['name' => $value])) {
                continue;
            }
            $component = new stdClass();
            $component->name = $value;
            $component->timecreated = time();
            $component->timemodified = time();
            $DB->insert_record('digitalta_components', $component);
        }
    }
    $local_digitalta_components = $DB->get_records('digitalta_components');
    $local_digitalta_components = array_column($local_digitalta_components, 'id', 'name');

    // Insert the modifiers
    $table = new xmldb_table('digitalta_modifiers');
    if ($dbman->table_exists($table)) {
        foreach (LOCAL_DIGITALTA_MODIFIERS as $value) {
            if ($DB->record_exists('digitalta_modifiers', ['name' => $value])) {
                continue;
            }
            $modifier = new stdClass();
            $modifier->name = $value;
            $modifier->timecreated = time();
            $modifier->timemodified = time();
            $DB->insert_record('digitalta_modifiers', $modifier);
        }
    }

    // Insert the themes
    $table = new xmldb_table('digitalta_themes');
    if ($dbman->table_exists($table)) {
        foreach (LOCAL_DIGITALTA_THEMES as $value) {
            if ($DB->record_exists('digitalta_themes', ['name' => $value])) {
                continue;
            }
            $theme = new stdClass();
            $theme->name = $value;
            $theme->timecreated = time();
            $theme->timemodified = time();
            $DB->insert_record('digitalta_themes', $theme);
        }
    }

    // Insert the resource types
    $table = new xmldb_table('digitalta_resources_types');
    if ($dbman->table_exists($table)) {
        foreach (LOCAL_DIGITALTA_RESOURCE_TYPES as $value) {
            if ($DB->record_exists('digitalta_resources_types', ['name' => $value])) {
                continue;
            }
            $resource_type = new stdClass();
            $resource_type->name = $value;
            $resource_type->timecreated = time();
            $resource_type->timemodified = time();
            $DB->insert_record('digitalta_resources_types', $resource_type);
        }
    }

    // Insert the resource formats
    $table = new xmldb_table('digitalta_resources_formats');
    if ($dbman->table_exists($table)) {
        foreach (LOCAL_DIGITALTA_RESOURCE_FORMATS as $value) {
            if ($DB->record_exists('digitalta_resources_formats', ['name' => $value])) {
                continue;
            }
            $resource_format = new stdClass();
            $resource_format->name = $value;
            $resource_format->timecreated = time();
            $resource_format->timemodified = time();
            $DB->insert_record('digitalta_resources_formats', $resource_format);
        }
    }

    return true;
}
