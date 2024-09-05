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
 * Cases class
 *
 * @package   local_digitalta
 * @copyright 2024 ADSDR-FUNIBER Scepter Team
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_digitalta;

require_once($CFG->dirroot . '/local/digitalta/classes/case.php');
require_once($CFG->dirroot . '/local/digitalta/classes/components.php');
require_once($CFG->dirroot . '/local/digitalta/classes/languages.php');
require_once($CFG->dirroot . '/local/digitalta/classes/reactions.php');
require_once($CFG->dirroot . '/local/digitalta/classes/resources.php');
require_once($CFG->dirroot . '/local/digitalta/classes/sections.php');
require_once($CFG->dirroot . '/local/digitalta/classes/tags.php');
require_once($CFG->dirroot . '/local/digitalta/classes/themes.php');
require_once($CFG->dirroot . '/local/digitalta/classes/utils/dateutils.php');

use local_digitalta\Components;
use local_digitalta\Languages;
use local_digitalta\Reactions;
use local_digitalta\Resources;
use local_digitalta\Sections;
use local_digitalta\StudyCase;
use local_digitalta\Tags;
use local_digitalta\Themes;
use local_digitalta\utils\DateUtils;

use Exception;
use stdClass;

/**
 * This class is used to manage the cases of the plugin
 *
 * @copyright 2024 ADSDR-FUNIBER Scepter Team
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class Cases
{
    /** @var string The table name for the cases. */
    private static $table = 'digitalta_cases';

    /**
     * Get a case by this id
     * 
     * @param  int            $id The id of the case
     * @param  bool           $extra_fields If true, it will return the extra fields
     * @return StudyCase|null The case
     */
    public static function get_case(int $id, bool $extra_fields = true): ?StudyCase
    {
        $case = self::get_cases(['id' => $id], $extra_fields)[0] ?? null;
        return $case;
    }

    /**
     * Get cases
     * 
     * @param  array $filters The filters to apply
     * @param  bool  $extra_fields If true, it will return the extra fields
     * @return array The cases
     */
    public static function get_cases(array $filters = [], bool $extra_fields = true): array
    {
        global $DB;
        $filters = self::prepare_filters($filters);
        $cases = $DB->get_records(self::$table, $filters);
        return array_values(array_map(
            function ($case) use ($extra_fields) {
                $case = new StudyCase($case);
                if ($extra_fields) {
                    $case = self::get_extra_fields($case);
                }
                return $case;
            },
        $cases));
    }

    /**
     * Prepare filters for cases
     *
     * @param  array $filters The filters to prepare
     * @return array The prepared filters
     */
    private static function prepare_filters($filters)
    {
        return $filters;
    }

    /**
     * Get extra fields for cases
     * 
     * @param  object $case The case
     * @return object The case with extra fields
     */
    public static function get_extra_fields($case)
    {
        global $PAGE;
        // Get the user data
        $user = get_complete_user_data("id", $case->userid);
        $picture = new \user_picture($user);
        $picture->size = 101;
        $case->user = [
            'id' => $user->id,
            'name' => $user->firstname . " " . $user->lastname,
            'email' => $user->email,
            'imageurl' => $picture->get_url($PAGE)->__toString(),
            'profileurl' => new \moodle_url('/user/profile.php', ['id' => $user->id])
        ];
        // Get the sections for the case
        $sections = Sections::get_sections([
            'component' => Components::get_component_by_name('case')->id,
            'componentinstance' => $case->id
        ]);
        $case->sections = array_map(function ($section) {
            return (object) [
                'id' => $section->id,
                'component' => $section->component,
                'componentinstance' => $section->componentinstance,
                'groupid' => $section->groupid,
                'sequence' => $section->sequence,
                'type' => $section->type,
                'title' => $section->title,
                'content' => $section->content
            ];
        }, $sections);
        // Get the themes for the case
        $themes = Themes::get_themes_for_component('case', $case->id);
        $case->themes = array_map(function($theme) {
            return (object) [
                'name' => $theme->name,
                'id' => $theme->id
            ];
        }, $themes);
        // Get the tags for the case
        $tags = Tags::get_tags_for_component('case', $case->id);
        $case->tags = array_map(function($tag) {
            return (object) [
                'name' => $tag->name,
                'id' => $tag->id
            ];
        }, $tags);
        $case->fixed_tags = [
            ['name' => Languages::get_language_name_by_code($case->lang)]
        ];
        // Get the case reactions
        $case->reactions = Reactions::get_reactions_for_render_component(
            Components::get_component_by_name('case')->id,
            $case->id
        );
        // Get the case creation date
        $case->timecreated_string = DateUtils::time_elapsed_string($case->timecreated);
        return $case;
    }

    /**
     * Add a case
     *
     * @param  object $case The case to add
     * @return int    The identifier of the case
     */
    public static function add_case($case): int
    {
        global $DB;
        // Create the case
        $record = self::prepare_metadata_record($case);
        $record->id = $DB->insert_record(self::$table, $record);
        // Create default sections
        $componentid = Components::get_component_by_name('case')->id;
        $sectiongeneralgroupid = Sections::get_group_by_name('General')->id;
        $sectiontexttypeid = Sections::get_type_by_name('text')->id;
        $sectiontitles = [
            get_string('concept:introduction', 'local_digitalta'),
            local_digitalta_get_element_translation('section_group', 'What?')[0],
            local_digitalta_get_element_translation('section_group', 'So What?')[0],
            local_digitalta_get_element_translation('section_group', 'Now What?')[0],
            get_string('concept:conclusion', 'local_digitalta')
        ];
        foreach ($sectiontitles as $sectiontitle) {
            unset($section);
            $section = new stdClass();
            $section->component         = $componentid;
            $section->componentinstance = $record->id;
            $section->groupid           = $sectiongeneralgroupid;
            $section->type              = $sectiontexttypeid;
            $section->title             = $sectiontitle;
            $section->content           = "";
            Sections::upsert_section($section);
        }
        // Update theme and tags
        if (property_exists($case, 'themes') && $case->themes) {
            Themes::update_themes('case', $record->id, $case->themes);
        }
        if (property_exists($case, 'tags') && $case->tags) {
            Tags::update_tags('case', $record->id, $case->tags);
        }
        return $record->id;
    }

    /**
     * Update a case
     *
     * @param  object      $case The case to update
     * @return object|null The case
     */
    public static function update_case($case)
    {
        global $CFG, $DB;
        // Get the current case
        if (!$current_case = self::get_case($case->id, false)) {
            throw new Exception('Error case not found');
        }
        // Validate the metadata
        $record = self::prepare_metadata_record($case, $current_case);
        // Update the time modified
        $record->timemodified = time();
        // If status is published, add or update the default resource
        if ($case->status == 1) {
            if ($resource = Resources::get_resource($record->resourceid)) {
                $resource->name        = $record->title;
                $resource->description = $record->description;
            } else {
                $resource               = new stdClass();
                $resource->userid       = $record->userid;
                $resource->name         = $record->title;
                $resource->description  = $record->description;
                $resource->type         = Resources::get_type_by_name('Study Case')->id;
                $resource->format       = Resources::get_format_by_name('Link')->id;
                $resource->path         = $CFG->wwwroot . '/local/digitalta/pages/cases/view.php?id=' . $record->id;
                $resource->lang         = $record->lang;
                $resource->timecreated  = time();
                $resource->timemodified = time();
            }
            $record->resourceid = Resources::upsert_resource($resource);
        }
        // Update the case
        if (!$DB->update_record(self::$table,  $record)) {
            throw new Exception('Error updating case');
            return false;
        }
        // Update the themes and tags
        if (property_exists($case, 'themes') && $case->themes) {
            Themes::update_themes('case', $record->id, $case->themes);
        }
        if (property_exists($case, 'tags') && $case->tags) {
            Tags::update_tags('case', $record->id, $case->tags);
        }
        // Return the case identifier
        return $case->id;    
    }

    /**
    * Prepare metadata record for database insertion.
    * 
    * @param  object    $case The case object.
    * @param  object    $current_case The current case object.
    * @return object    The prepared metadata record.
    * @throws Exception If the case type is invalid.
    */
    private static function prepare_metadata_record($case, $current_case = null)
    {
        global $USER;
        self::validate_metadata($case);
        $record               = new stdClass();
        $record->id           = $case->id
            ?? $current_case->id
            ?? null;
        $record->experienceid = $case->experienceid
            ?? $current_case->experienceid
            ?? null;
        $record->resourceid   = $case->resourceid
            ?? $current_case->resourceid
            ?? 0;
        $record->userid       = $case->userid
            ?? $current_case->userid
            ?? $USER->id;
        $record->title        = $case->title;
        $record->description  = $case->description
            ?? $current_case->description
            ?? null;
        $record->lang         = $case->lang
            ?? $current_case->lang
            ?? null;
        $record->status       = $case->status
            ?? $current_case->status
            ?? 0;
        $record->timecreated  = $case->timecreated
            ?? $current_case->timecreated
            ?? time();
        $record->timemodified = time();
        return $record;
    }

    /**
     * Validate the metadata of an case.
     * 
     * @param  object $case The case object to check.
     */
    private static function validate_metadata(object $case)
    {
        $keys = ['title'];
        $missing_keys = [];
        foreach ($keys as $key) {
            if (!property_exists($case, $key) || empty($case->{$key}) || is_null($case->{$key})) {
                $missing_keys[] = $key;
            }
        }
        if (!empty($missing_keys)) {
            throw new Exception('Error adding case. Missing fields: ' . implode(', ', $missing_keys));
        }
    }

    /**
     * Delete a case
     *
     * @param  mixed $caseorid The case to delete or its identifier
     * @return bool  True if the case was deleted, false otherwise
     */
    public static function delete_case($caseorid)
    {
        global $DB, $USER;
        $case = is_object($caseorid) ? $caseorid : self::get_case($caseorid);
        if (!$DB->record_exists(self::$table, ['id' => $case->id])) {
            throw new Exception('Error case not found');
        }
        // Check permissions
        if (!self::check_permissions($case, $USER)) {
            throw new Exception('Error permissions');
        }
        // Get the component type identifier
        $componentid = Components::get_component_by_name('case')->id;
        // Delete the sections
        Sections::delete_all_sections_for_component(
            $componentid,
            $case->id
        );
        // Delete the associated resource
        if ($resource = Resources::get_resource($case->resourceid)) {
            Resources::delete_resource($resource);
        }
        // Delete the contexts
        Context::delete_all_contexts_for_component(
            $componentid,
            $case->id
        );
        // Delete the reactions
        Reactions::delete_all_reactions_for_component(
            $componentid,
            $case->id
        );
        // Delete the resource assignations
        Resources::delete_all_assignments_for_component(
            $componentid,
            $case->id
        );
        // Delete the case
        return $DB->delete_records(self::$table, ['id' => $case->id]);
    }

    /**
     * Check user permissions over cases
     *
     * @param  object $case The case object
     * @param  object $user The user object
     * @return bool   True if the user has permissions, false otherwise
     */
    public static function check_permissions($case, $user)
    {
        if ($user->id == $case->userid || is_siteadmin($user)) {
            return true;
        }
        return false;
    }
}
