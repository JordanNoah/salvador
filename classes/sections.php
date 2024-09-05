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
 * Sections class
 *
 * @package   local_digitalta
 * @copyright 2024 ADSDR-FUNIBER Scepter Team
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_digitalta;

use Exception;
use quizaccess_seb\property_list;
use stdClass;

/**
 * This class is used to manage the sections of the plugin
 *
 * @copyright 2024 ADSDR-FUNIBER Scepter Team
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class Sections
{
    /** @var string The table name for the sections. */
    private static $table = 'digitalta_sections';

    /** @var string The table name for the groups. */
    private static $groups_table = 'digitalta_sections_groups';

    /** @var string The table name for the types. */
    private static $types_table = 'digitalta_sections_types';

    /**
     * Get a section by its id
     *
     * @param  int         $id The ID of the section.
     * @return object|null The section
     */
    public static function get_section(int $id) : ?object
    {
        return self::get_sections(['id' => $id])[0] ?? null;
    }

    /**
     * Get sections
     *
     * @param  array $filters The filters to apply
     * @return array The sections
     */
    public static function get_sections(array $filters = []): array
    {
        global $DB;
        $filters = self::prepare_filters($filters);
        return array_values($DB->get_records(self::$table, $filters, 'component, componentinstance, groupid, sequence'));
    }

    /**
     * Prepare filters for sections
     *
     * @param  array $filters The filters to prepare
     * @return array The prepared filters
     */
    private static function prepare_filters(array $filters): array
    {
        $prepared_filters = [];
        foreach ($filters as $filter_key => $filter_value) {
            switch ($filter_key) {
                case 'groupname':
                    $prepared_filters['groupid'] = self::get_group_by_name($filter_value)->id;
                    break;
                default:
                    $prepared_filters[$filter_key] = $filter_value;
                    break;
            }
        }
        return $prepared_filters;
    }

    /**
     * Upsert a section
     * 
     * @param  object      $section The section to upsert.
     * @return object|null The section
     */
    public static function upsert_section(object $section): int
    {
        global $DB;
        $record = new stdClass();
        $record = self::prepare_metadata_record($section);
        if (property_exists($record, 'id')) {
            $DB->update_record(self::$table, $record);
        } else {
            $record->id = $DB->insert_record(self::$table, $record);
        }
        return $record->id;
    }

    /**
    * Prepare metadata record for database insertion.
    * 
    * @param  object    $section The section object.
    * @return object    The prepared metadata record.
    * @throws Exception If the section type is invalid.
    */
    private static function prepare_metadata_record(object $section): object
    {
        $record = new stdClass();
        self::validate_metadata($section);
        if (property_exists($section, 'id')
                and !empty($section->id)
                and $section->id > 0) {
            $record = self::get_section($section->id);
        } else if (property_exists($section, 'groupid')
                and !empty($section->groupid)
                and $section->groupid > 0) {
            $record->groupid = $section->groupid;
        } else if (property_exists($section, 'groupname')
                and !empty($section->groupname)
                and $group = self::get_group_by_name($section->groupname)) {
            $record->groupid = $group->id;
        } else {
            $record->groupid = self::get_group_by_name('General')->id;
        }
        $record->component         = $section->component;
        $record->componentinstance = $section->componentinstance;

        if (property_exists($section, 'sequence') && !empty($section->sequence) && $section->sequence > 0) {
            $record->sequence = $section->sequence;
        } elseif (property_exists($record, 'sequence') && !empty($record->sequence) && $record->sequence > 0) {
            // Do nothing, sequence is already set and valid
        } else {
            $record->sequence = self::get_next_available_sequence_for_group(
                $section->component,
                $section->componentinstance,
                $record->groupid
            );
        }

        $record->type              = $section->type;
        $record->title             = $section->title;
        $record->content           = $section->content;
        $record->timecreated       = property_exists($section, 'timecreated')
            ? $section->timecreated
            : time();
        $record->timemodified      = time();
        return $record;
    }

    /**
     * Validate the metadata of a section.
     * 
     * @param  object $section The section object to check.
     */
    private static function validate_metadata(object $section)
    {
        // General keys
        $keys = ['component', 'componentinstance', 'type'];
        $missing_keys = [];
        foreach ($keys as $key) {
            if (!property_exists($section, $key) || empty($section->{$key}) || is_null($section->{$key})) {
                $missing_keys[] = $key;
            }
        }
        // Group related keys
        $valid_id = property_exists($section, 'id')
            && !empty($section->id)
            && $section->id > 0;
        $valid_groupid = property_exists($section, 'groupid')
            && !empty($section->groupid)
            && $section->groupid > 0;
        $valid_groupname = property_exists($section, 'groupname')
            && !empty($section->groupname);
        if (!$valid_id && !$valid_groupid && !$valid_groupname) {
            $missing_keys[] = 'groupid';
        }
        // Throw exception if there are missing keys
        if (!empty($missing_keys)) {
            throw new Exception('Error adding section. Missing fields: ' . implode(', ', $missing_keys));
        }
    }

    /**
     * Delete a section by id.
     * 
     * @param  int  $id The id of the section.
     * @return bool True if the section was deleted, false otherwise.
     */
    public static function delete_section(int $id): bool
    {
        global $DB;
        return $DB->delete_records(self::$table, ['id' => $id]);
    }

    /**
     * Delete all sections for a component.
     * 
     * @param int $component The component id.
     * @param int $componentinstance The component instance id.
     */
    public static function delete_all_sections_for_component(int $component, int $componentinstance)
    {
        global $DB;
        $conditions = [
            'component' => $component,
            'componentinstance' => $componentinstance
        ];
        $DB->delete_records(self::$table, $conditions);
    }

    /**
     * Get all the section types.
     * 
     * @return array The section types.
     */
    public static function get_types(): array
    {
        global $DB;
        if (!$types = $DB->get_records(self::$types_table)) {
            return [];
        }
        return $types;
    }

    /**
     * Get a section type by its identifier.
     * 
     * @param  int         $id The identifier of the type.
     * @return object|null The type object.
     */
    public static function get_type(int $id)
    {
        global $DB;
        if (!$type = $DB->get_record(self::$types_table, ['id' => $id])) {
            return null;
        }
        return $type;
    }

    /**
     * Get a section type by its name.
     * 
     * @param  string      $name The name of the type.
     * @return object|null The type object.
     */
    public static function get_type_by_name(string $name)
    {
        global $DB;
        if (!$type = $DB->get_record(self::$types_table, ['name' => $name])) {
            return null;
        }
        return $type;
    }

    /**
     * Get all the section groups.
     *
     * @return array The section groups.
     */
    public static function get_groups(): array
    {
        global $DB;
        if (!$groups = $DB->get_records(self::$groups_table)) {
            return [];
        }
        return $groups;
    }

    /**
     * Get a section group by its identifier.
     *
     * @param  int         $id The identifier of the group.
     * @return object|null The group object.
     */
    public static function get_group(int $id)
    {
        global $DB;
        if (!$group = $DB->get_record(self::$groups_table, ['id' => $id])) {
            return null;
        }
        return $group;
    }

    /**
     * Get a section group by its name.
     *
     * @param  string      $name The name of the group.
     * @return object|null The group object.
     */
    public static function get_group_by_name(string $name)
    {
        global $DB;
        if (!$group = $DB->get_record(self::$groups_table, ['name' => $name])) {
            return null;
        }
        return $group;
    }

    /**
     * Get the next available sequence for a component.
     * 
     * @param  int $component The component id.
     * @param  int $componentinstance The component instance id.
     * @param  int $groupid The group id.
     * @return int The next available sequence.
     */
    public static function get_next_available_sequence_for_group(int $component, int $componentinstance, int $groupid): int
    {
        global $DB;
        if (!$sequence = $DB->get_field(self::$table, 'MAX(sequence) as sequence', [
                'component' => $component,
                'componentinstance' => $componentinstance,
                'groupid' => $groupid])) {
            return 1;
        }
        return $sequence + 1;
    }
}
