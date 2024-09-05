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
 * Resources class
 *
 * @package   local_digitalta
 * @copyright 2024 ADSDR-FUNIBER Scepter Team
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_digitalta;

require_once($CFG->dirroot . '/local/digitalta/classes/components.php');
require_once($CFG->dirroot . '/local/digitalta/classes/context.php');
require_once($CFG->dirroot . '/local/digitalta/classes/languages.php');
require_once($CFG->dirroot . '/local/digitalta/classes/reactions.php');
require_once($CFG->dirroot . '/local/digitalta/classes/resource.php');
require_once($CFG->dirroot . '/local/digitalta/classes/themes.php');
require_once($CFG->dirroot . '/local/digitalta/classes/tags.php');

use local_digitalta\Components;
use local_digitalta\Context;
use local_digitalta\Languages;
use local_digitalta\Reactions;
use local_digitalta\Resource;
use local_digitalta\Themes;
use local_digitalta\Tags;

use Exception;
use stdClass;

/**
 * This class is used to manage the resources.
 *
 * @copyright 2024 ADSDR-FUNIBER Scepter Team
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class Resources
{
    /** @var string The name of the database table storing the resources. */
    private static $table = 'digitalta_resources';

    /** @var string The name of the database table storing the resource assignments. */
    private static $assign_table = 'digitalta_resources_assign';

    /** @var string The name of the database table storing the types. */
    private static $types_table = 'digitalta_resources_types';

    /** @var string The name of the database table storing the formats. */
    private static $formats_table = 'digitalta_resources_formats';

    /**
     * Get a resource by its ID.
     * 
     * @param  int            $id int The ID of the resource.
     * @return Resource|null The resource object.
     */
    public static function get_resource(int $id, bool $extra_fields = true): ?Resource
    {
        return self::get_resources(['id' => $id], $extra_fields)[0] ?? null;
    }

    /**
     * Get resources
     *
     * @param  array $filters The filters to apply
     * @param  bool  If true, it will return the extra fields
     * @return array The resources
     */
    public static function get_resources(array $filters = [], bool $extra_fields = true): array
    {
        global $DB;
        $filters = self::prepare_filters($filters);
        $resources = $DB->get_records(self::$table, $filters);
        return array_values(array_map(
            function ($resource) use ($extra_fields) {
                $resource = new Resource($resource);
                if ($extra_fields) {
                    $resource = self::get_extra_fields($resource);
                }
                return $resource;
            },
        $resources));
    }

    /**
     * Prepare filters for resources
     *
     * @param  array $filters The filters to prepare
     * @return array The prepared filters
     */
    private static function prepare_filters(array $filters): array
    {
        $prepared_filters = [];
        foreach ($filters as $filter_key => $filter_value) {
            switch ($filter_key) {
                case 'typename':
                    $prepared_filters['type'] = self::get_type_by_name($filter_value)->id;
                    break;
                case 'formatname':
                    $prepared_filters['format'] = self::get_format_by_name($filter_value)->id;
                default:
                    $prepared_filters[$filter_key] = $filter_value;
                    break;
            }
        }
        return $prepared_filters;
    }

    /**
     * Get extra fields for a resource.
     * 
     * @param  Resource $resource The resource object.
     * @return object   The resource object with extra fields.
     */
    public static function get_extra_fields(Resource $resource)
    {
        // Get the themes for the resource
        $themes = Themes::get_themes_for_component('resource', $resource->id);
        $resource->themes = array_map(function ($theme) {
            return (object) [
                'name' => $theme->name,
                'id' => $theme->id
            ];
        }, $themes);
        // Get the tags for the resource
        $tags = Tags::get_tags_for_component('resource', $resource->id);
        $resource->tags = array_map(function ($tag) {
            return (object) [
                'name' => $tag->name,
                'id' => $tag->id
            ];
        }, $tags);
        $resource->fixed_tags = [
            ['name' => Languages::get_language_name_by_code($resource->lang)]
        ];
        // Get the resource reactions
        $resource->reactions = Reactions::get_reactions_for_render_component(
            Components::get_component_by_name('resource')->id,
            $resource->id
        );
        return $resource;
    }

    /**
     * Upsert a resource.
     * 
     * @param  object $resource The resource to upsert.
     * @return int    The identifier of the upserted resource.
     */
    public static function upsert_resource($resource): int
    {
        global $DB;
        $record = new stdClass;
        $record = self::prepare_metadata_record($resource);
        if (property_exists($resource, 'id')
                and !empty($resource->id)
                and $resource->id > 0) {
            if (!$current_resource = self::get_resource($resource->id)) {
                return null;
            }
            $record->id          = $current_resource->id;
            $record->timecreated = $current_resource->timecreated;
            $DB->update_record(self::$table, $record);
        } else {
            $record->id = $DB->insert_record(self::$table, $record);
        }
        if (property_exists($resource, 'themes') && $resource->themes) {
            Themes::update_themes('resource', $record->id, $resource->themes);
        }
        if (property_exists($resource, 'tags') && $resource->tags) {
            Tags::update_tags('resource', $record->id, $resource->tags);
        }
        return $record->id;
    }

    /**
    * Prepare metadata record for database insertion.
    * 
    * @param  object    $resource The resource object.
    * @return object    The prepared metadata record.
    * @throws Exception If the resource type is invalid.
    */
    private static function prepare_metadata_record(object $resource): object
    {
        global $USER;
        self::validate_metadata($resource);
        $record               = new Resource();
        $record->name         = $resource->name;
        $record->userid       = $USER->id; 
        $record->description  = $resource->description;
        $record->type         = $resource->type;
        $record->format       = $resource->format;
        $record->lang         = $resource->lang;
        $record->path         = $resource->path;
        $record->timecreated  = time();
        $record->timemodified = time();
        return $record;
    }

    /**
     * Validate the metadata of a resource.
     * 
     * @param  object $resource The resource object to check.
     */
    private static function validate_metadata(object $resource)
    {
        $keys = ['name', 'type', 'format', 'lang'];
        $missing_keys = [];
        foreach ($keys as $key) {
            if (!property_exists($resource, $key) || empty($resource->{$key}) || is_null($resource->{$key})) {
                $missing_keys[] = $key;
            }
        }
        if (!empty($missing_keys)) {
            throw new Exception('Error adding resource. Missing fields: ' . implode(', ', $missing_keys));
        }
    }

    /**
     * Delete a resource.
     * 
     * @param  mixed $resourceorid The resource to delete or its identifier.
     * @return bool  True if the resource was deleted, false otherwise.
     */
    public static function delete_resource($resourceorid): bool
    {
        global $DB, $USER;
        $resource = is_object($resourceorid) ? $resourceorid : self::get_resource($resourceorid);
        if (!$DB->record_exists(self::$table, ['id' => $resource->id])) {
            throw new Exception('Error resource not found');
        }
        // Check permissions
        if (!self::check_permissions($resource, $USER)) {
            throw new Exception('Error permissions');
        }
        // Get the component type identifier
        $componentid = Components::get_component_by_name('resource')->id;
        // Delete the contexts
        Context::delete_all_contexts_for_component(
            $componentid,
            $resource->id
        );
        // Delete the reactions
        Reactions::delete_all_reactions_for_component(
            $componentid,
            $resource->id
        );
        return $DB->delete_records(self::$table, ['id' => $resource->id]);
    }

    /**
     * Get all the resource types.
     * 
     * @return array The resource types.
     */
    public static function get_types(): array
    {
        global $DB;
        return array_values($DB->get_records(self::$types_table));
    }

    /**
     * Get a resource type by its identifier.
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
     * Get a resource type by its name.
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
     * Get all the resource formats.
     * 
     * @return array The resource formats.
     */
    public static function get_formats(): array
    {
        global $DB;
        return $DB->get_records(self::$formats_table);
    }

    /**
     * Get a resource format by its identifier.
     * 
     * @param  int         $id The identifier of the format.
     * @return object|null The format object.
     */
    public static function get_format(int $id)
    {
        global $DB;
        if (!$format = $DB->get_record(self::$formats_table, ['id' => $id])) {
            return null;
        }
        return $format;
    }

    /**
     * Get a resource format by its name.
     * 
     * @param  string      $name The name of the format.
     * @return object|null The format object.
     */
    public static function get_format_by_name(string $name)
    {
        global $DB;
        if (!$format = $DB->get_record(self::$formats_table, ['name' => $name])) {
            return null;
        }
        return $format;
    }

    /**
     * Get all the resource assignments.
     *
     * @param string $component The component to get the assignments for.
     * @param int    $componentinstance The instance of the component.
     * @return array The resource assignments.
     */
    public static function get_assignments_for_component(string $component, int $componentinstance)
    {
        global $DB;
        $componentid = Context::is_valid('component', $component);
        if (!$componentid) {
            return [];
        }
        return array_values($DB->get_records(self::$assign_table, [
            'component' => $componentid,
            'componentinstance' => $componentinstance]));
    }

    /**
     * Get a resource assignment.
     *
     * @param int    $resourceid The ID of the resource.
     * @param string $component The component to get the assignment for.
     * @param int    $componentinstance The instance of the component.
     * @return object The resource assignment.
     */
    public static function get_assignment(int $resourceid, string $component, int $componentinstance)
    {
        global $DB;
        $componentid = Context::is_valid('component', $component);
        if (!$componentid) {
            return null;
        }
        return $DB->get_record(self::$assign_table, [
            'resourceid' => $resourceid,
            'component' => $componentid,
            'componentinstance' => $componentinstance]);
    }

    /**
     * Assign a resource to a component.
     * 
     * @param  int    $resourceid The ID of the resource.
     * @param  string $component The component to assign the resource to.
     * @param  int    $componentinstance The instance of the component.
     * @param  string $description The description of the assignment.
     * @return int    The ID of the assignment.
     */
    public static function assign_resource(int $resourceid, string $component, int $componentinstance, string $description = null)
    {
        global $DB;
        if (!$componentid = Context::is_valid('component', $component)) {
            throw new Exception('Invalid component');
        }
        $record                    = new \stdClass();
        $record->resourceid        = $resourceid;
        $record->component         = $componentid;
        $record->componentinstance = $componentinstance;
        $record->description       = $description;
        $record->timecreated       = time();
        $record->timemodified      = time();
        return $DB->insert_record(self::$assign_table, $record);
    }

    /**
     * Remove a resource assignment.
     * 
     * @param  int $id The ID of the assignment to remove.
     * @return bool True if the assignment was removed, false otherwise.
     */
    public static function unassign_resource(int $id)
    {
        global $DB;
        return $DB->delete_records(self::$assign_table, ['id' => $id]);
    }

    /**
     * Delete all assignments for a component.
     *
     * @param int $component The component to delete the assignments for.
     * @param int $componentinstance The instance of the component.
     */
    public static function delete_all_assignments_for_component(int $component, int $componentinstance)
    {
        global $DB;
        $conditions = [
            'component' => $component,
            'componentinstance' => $componentinstance
        ];
        $DB->delete_records(self::$assign_table, $conditions);
    }

    /**
     * Check user permissions over resources
     *
     * @param  object $resource The resource object
     * @param  object $user The user object
     * @return bool   True if the user has permissions, false otherwise
     */
    public static function check_permissions($resource, $user)
    {
        if ($user->id == $resource->userid || is_siteadmin($user)) {
            return true;
        }
        return false;
    }
}
