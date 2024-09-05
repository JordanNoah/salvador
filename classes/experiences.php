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
 * Experiences class
 *
 * @package   local_digitalta
 * @copyright 2024 ADSDR-FUNIBER Scepter Team
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_digitalta;

require_once($CFG->dirroot . '/local/digitalta/classes/components.php');
require_once($CFG->dirroot . '/local/digitalta/classes/context.php');
require_once($CFG->dirroot . '/local/digitalta/classes/languages.php');
require_once($CFG->dirroot . '/local/digitalta/classes/experience.php');
require_once($CFG->dirroot . '/local/digitalta/classes/reactions.php');
require_once($CFG->dirroot . '/local/digitalta/classes/resources.php');
require_once($CFG->dirroot . '/local/digitalta/classes/sections.php');
require_once($CFG->dirroot . '/local/digitalta/classes/tags.php');
require_once($CFG->dirroot . '/local/digitalta/classes/themes.php');
require_once($CFG->dirroot . '/local/digitalta/classes/utils/dateutils.php');

use local_digitalta\Components;
use local_digitalta\Context;
use local_digitalta\Experience;
use local_digitalta\Languages;
use local_digitalta\Reactions;
use local_digitalta\Resources;
use local_digitalta\Sections;
use local_digitalta\Tags;
use local_digitalta\Themes;
use local_digitalta\utils\DateUtils;

use Exception;
use stdClass;

/**
 * This class is used to manage the experiences of the plugin
 *
 * @copyright 2024 ADSDR-FUNIBER Scepter Team
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class Experiences
{
    /** @var string The table name for the experiences. */
    private static $table = 'digitalta_experiences';

    /**
     * Get an experience by this id
     * 
     * @param  int             $id The id of the experience
     * @param  bool            $extra_fields If true, it will return the extra fields
     * @return Experience|null The experience
     */
    public static function get_experience(int $id, bool $extra_fields = true): ?Experience
    {
        $experience = self::get_experiences(['id' => $id], $extra_fields)[0] ?? null;
        return $experience;
    }

    /**
     * Get experiences
     * 
     * @param  array $filters The filters to apply
     * @param  bool  $extra_fields If true, it will return the extra fields
     * @return array The experiences
     */
    public static function get_experiences(array $filters = [], bool $extra_fields = true): array
    {
        global $DB;
        $filters = self::prepare_filters($filters);
        $experiences = $DB->get_records(self::$table, $filters);
        return array_values(array_map(
            function ($experience) use ($extra_fields) {
                $experience = new Experience($experience);
                if ($extra_fields) {
                    $experience = self::get_extra_fields($experience);
                }
                return $experience;
            },
        $experiences));
    }

    /**
     * Prepare filters for experiences
     *
     * @param  array $filters The filters to prepare
     * @return array The prepared filters
     */
    private static function prepare_filters($filters)
    {
        return $filters;
    }

    /**
     * Get extra fields for experiences
     * 
     * @param  Experience $experience The experience
     * @return object     The experience with extra fields
     */
    public static function get_extra_fields(Experience $experience)
    {
        global $PAGE;
        // Get the user data 
        $user = get_complete_user_data('id', $experience->userid);
        $user_picture = new \user_picture($user);
        $user_picture->size = 101;
        $experience->user = [
            'id' => $user->id,
            'name' => $user->firstname . " " . $user->lastname,
            'email' => $user->email,
            'imageurl' => $user_picture->get_url($PAGE)->__toString(),
            'profileurl' => new \moodle_url('/user/profile.php', ['id' => $user->id])
        ];
        // Get the sections for the experience
        $sections = Sections::get_sections([
            'component' => Components::get_component_by_name('experience')->id,
            'componentinstance' => $experience->id
        ]);
        $experience->sections = array_map(function ($section) {
            return (object) [
                'id' => $section->id,
                'component' => $section->component,
                'componentinstance' => $section->componentinstance,
                'groupid' => $section->groupid,
                'sequence' => $section->sequence,
                'type' => $section->type,
                'content' => $section->content
            ];
        }, $sections);
        // Get the themes for the experience
        $themes = Themes::get_themes_for_component('experience', $experience->id);
        $experience->themes = array_map(function ($theme) {
            return (object) [
                'name' => $theme->name,
                'id' => $theme->id
            ];
        }, $themes);
        // Get the tags for the experience
        $tags = Tags::get_tags_for_component('experience', $experience->id);
        $experience->tags = array_map(function ($tag) {
            return (object) [
                'name' => $tag->name,
                'id' => $tag->id
            ];
        }, $tags);
        $experience->fixed_tags = [
            ['name' => $experience->visible
                ? get_string('visibility:public', 'local_digitalta')
                : get_string('visibility:private', 'local_digitalta')],
            ['name' => Languages::get_language_name_by_code($experience->lang)]
        ];
        // Get the experience picture
        $experience->pictureurl = self::get_picture_url($experience);
        // Get the experience reactions
        $experience->reactions = Reactions::get_reactions_for_render_component(
            Components::get_component_by_name('experience')->id,
            $experience->id
        );
        // Get the experience creation date
        $experience->timecreated_string = DateUtils::time_elapsed_string($experience->timecreated);
        return $experience;
    }

    /**
     * Gets the picture url for an experience
     *
     * @param  object $experience The experience
     * @return string|bool The picture url or false if there is no picture
     */
    public static function get_picture_url($experience)
    {
        global $OUTPUT;
        return $OUTPUT->get_generated_image_for_id($experience->id);
    }

    /**
     * Upsert an experience
     *
     * @param  object    $experience The experience to upsert
     * @return int       The upserted experience
     * @throws Exception If metadata fields are missing.
     */
    public static function upsert_experience($experience): int
    {
        global $DB;
        $record = new stdClass;
        $record = self::prepare_metadata_record($experience);
        if (property_exists($experience, 'id')
                and !empty($experience->id)
                and $experience->id > 0) {
            if (!$current_experience = self::get_experience($experience->id, false)) {
                return null;
            }
            $record->id          = $current_experience->id;
            $record->timecreated = $current_experience->timecreated;
            $DB->update_record(self::$table, $record);
        } else {
            $record->id = $DB->insert_record(self::$table, $record);
            // Create the default sections for the experience
            $componentid = Components::get_component_by_name('experience')->id;
            $sectiontexttypeid = Sections::get_type_by_name('text')->id;
            $sectiongroupnames = ["What?", "So What?", "Now What?"];
            foreach ($sectiongroupnames as $sectiongroupname) {
                $section = new stdClass();
                $section->component         = $componentid;
                $section->componentinstance = $record->id;
                $section->groupid           = Sections::get_group_by_name($sectiongroupname)->id;
                $section->sequence          = null;
                $section->type              = $sectiontexttypeid;
                $section->title             = "";
                $section->content           = "";
                $section->id = Sections::upsert_section($section);
                if ($sectiongroupname == "What?") {
                    $experience->sections[0]['id'] = $section->id;
                }
                unset($section);
            }
        }
        // Sections
        if (!empty($experience->sections)) {
            foreach ($experience->sections as $section) {
                $section                    = (object) $section;
                $section->component         = Components::get_component_by_name('experience')->id;
                $section->componentinstance = $record->id;
                if ($section->groupname) {
                    $section->groupid = Sections::get_group_by_name($section->groupname)->id;
                }
                if ($section->typename) {
                    $section->type = Sections::get_type_by_name($section->typename)->id;
                }
                Sections::upsert_section($section);
            }
        }
        // Update theme and tags
        if (property_exists($experience, 'themes') && $experience->themes) {
            Themes::update_themes('experience', $record->id, $experience->themes);
        }
        if (property_exists($experience, 'tags') && $experience->tags) {
            Tags::update_tags('experience', $record->id, $experience->tags);
        }
        return $record->id;
    }

    /**
    * Prepare metadata record for database insertion.
    * 
    * @param  object    $experience The experience object.
    * @return object    The prepared metadata record.
    * @throws Exception If the experience type is invalid.
    */
    private static function prepare_metadata_record($experience)
    {
        global $USER;
        self::validate_metadata($experience);
        $record               = new Experience();
        $record->userid       = $USER->id;
        $record->title        = $experience->title;
        $record->lang         = $experience->lang;
        $record->visible      = $experience->visible;
        $record->status       = $experience->status ?? 0;
        $record->timecreated  = time();
        $record->timemodified = time();
        return $record;
    }

    /**
     * Validate the metadata of an experience.
     * 
     * @param  object $experience The experience object to check.
     */
    private static function validate_metadata(object $experience)
    {
        $keys = ['title', 'lang'];
        $missing_keys = [];
        foreach ($keys as $key) {
            if (!property_exists($experience, $key) || empty($experience->{$key}) || is_null($experience->{$key})) {
                $missing_keys[] = $key;
            }
        }
        if (!empty($missing_keys)) {
            throw new Exception('Error adding experience. Missing fields: ' . implode(', ', $missing_keys));
        }
    }

    /**
     * Delete an experience
     *
     * @param  mixed $experienceorid The experience to delete or its identifier
     * @return bool  True if the experience was deleted, false otherwise
     */
    public static function delete_experience($experienceorid): bool
    {
        global $DB, $USER;
        $experience = is_object($experienceorid) ? $experienceorid : self::get_experience($experienceorid);
        if (!$DB->record_exists(self::$table, ['id' => $experience->id])) {
            throw new Exception('Error experience not found');
        }
        // Check permissions
        if (!self::check_permissions($experience, $USER)) {
            throw new Exception('Error permissions');
        }
        // Get the component type identifier
        $componentid = Components::get_component_by_name('experience')->id;
        // Delete the sections
        Sections::delete_all_sections_for_component(
            $componentid,
            $experience->id
        );
        // Delete the contexts
        Context::delete_all_contexts_for_component(
            $componentid,
            $experience->id
        );
        // Delete the reactions
        Reactions::delete_all_reactions_for_component(
            $componentid,
            $experience->id
        );
        // Delete the resource assignations
        Resources::delete_all_assignments_for_component(
            $componentid,
            $experience->id
        );
        // Delete the experience
        return $DB->delete_records(self::$table, ['id' => $experience->id]);
    }

    /**
     * Toggles the status of an experience
     * 
     * @param int $experienceid
     */
    public static function toggle_status($experienceid)
    {
        global $DB, $USER;
        if (!$experience = self::get_experience($experienceid, false)) {
            throw new Exception('Error experience not found');
        }
        if (!self::check_permissions($experience, $USER)) {
            throw new Exception('Error permissions');
        }
        $status = $experience->status == 1 ? 0 : 1;
        $record = new stdClass();
        $record->id = $experience->id;
        $record->status = $status;
        if (!$DB->update_record(self::$table, $record)) {
            throw new Exception('Error updating experience');
        };
        return $status;
    }

    /**
     * Check user permissions over experiences
     *
     * @param  object $experience The experience object
     * @param  object $user The user object
     * @return bool   True if the user has permissions, false otherwise
     */
    public static function check_permissions($experience, $user)
    {
        if ($user->id == $experience->userid || is_siteadmin($user)) {
            return true;
        }
        return false;
    }
}
