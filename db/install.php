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
 * Install steps for the local_digitalta plugin.
 *
 * @package    local_digitalta
 * @copyright  2024 ADSDR-FUNIBER Scepter Team
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/local/digitalta/locallib.php');

/**
 * Install the local_digitalta plugin.
 */
function xmldb_local_digitalta_install() {
    global $DB;

    // Insert the components
    foreach (LOCAL_DIGITALTA_COMPONENTS as $value) {
        $component = new stdClass();
        $component->name = $value;
        $component->timecreated = time();
        $component->timemodified = time();
        $DB->insert_record('digitalta_components', $component);
    }

    // Insert the modifiers
    foreach (LOCAL_DIGITALTA_MODIFIERS as $value) {
        $modifier = new stdClass();
        $modifier->name = $value;
        $modifier->timecreated = time();
        $modifier->timemodified = time();
        $DB->insert_record('digitalta_modifiers', $modifier);
    }

    // Insert the themes
    foreach (LOCAL_DIGITALTA_THEMES as $value) {
        $theme = new stdClass();
        $theme->name = $value;
        $theme->timecreated = time();
        $theme->timemodified = time();
        $DB->insert_record('digitalta_themes', $theme);
    }

    // Insert the resource types
    foreach (LOCAL_DIGITALTA_RESOURCE_TYPES as $value) {
        $resource = new stdClass();
        $resource->name = $value;
        $resource->timecreated = time();
        $resource->timemodified = time();
        $DB->insert_record('digitalta_resources_types', $resource);
    }

    // Insert the resource formats
    foreach (LOCAL_DIGITALTA_RESOURCE_FORMATS as $value) {
        $resource = new stdClass();
        $resource->name = $value;
        $resource->timecreated = time();
        $resource->timemodified = time();
        $DB->insert_record('digitalta_resources_formats', $resource);
    }

    // Insert the section types
    foreach (LOCAL_DIGITALTA_SECTION_TYPES as $value) {
        $section = new stdClass();
        $section->name = $value;
        $section->timecreated = time();
        $section->timemodified = time();
        $DB->insert_record('digitalta_sections_types', $section);
    }

    // Insert the section groups
    foreach (LOCAL_DIGITALTA_SECTION_GROUPS as $value) {
        $section = new stdClass();
        $section->name = $value;
        $section->timecreated = time();
        $section->timemodified = time();
        $DB->insert_record('digitalta_sections_groups', $section);
    }
}
