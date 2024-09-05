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
 * Tags class
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

/**
 * This class is used to manage the tags of the plugin
 *
 * @copyright 2024 ADSDR-FUNIBER Scepter Team
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class Tags
{
    /** @var string The name of the database table storing the tags. */
    private static $table = 'digitalta_tags';

    /**
     * Get a tag by its ID.
     *
     * @param  int         $id The ID of the tag.
     * @return object|null The retrieved tag object.
     */
    public static function get_tag(int $id) : ?object
    {
        return self::get_tags(['id' => $id])[0] ?? null;
    }

    /**
     * Get all tags.
     *
     * @param  array $filters The filters to apply
     * @return array An array containing all tags.
     */
    public static function get_tags(array $filters = []): array
    {
        global $DB;
        return array_values($DB->get_records(self::$table, $filters));
    }

    /**
     * Get all tags by text
     *
     * @param string $text
     * @return array
     */
    public static function get_tags_by_text($text): array
    {
        $tags = self::get_tags();
        if (empty($text)) {
            return $tags;
        }
        return array_values(array_filter($tags, function ($tag) use ($text) {
            return stripos($tag->name, $text) !== false;
        }));
    }

    /**
     * Check if a tag object is valid.
     *
     * @param  string $tagname The tag to validate.
     * @return bool   True if the tag is valid, false otherwise.
     */
    public static function is_valid(string $tagname): bool
    {
        if (empty($tagname)) {
            return false;
        }   
        return true;
    }

    /**
     * Add a new tag.
     *
     * @param  string    $tagname The tag to add.
     * @return int       The ID of the added tag.
     * @throws Exception If the tag is invalid.
     */
    public static function add_tag(string $tagname): int
    {
        global $DB;
        if (!self::is_valid($tagname)) {
            throw new Exception('Invalid tag name');
        }
        $tag = new stdClass();
        $tag->name = $tagname;
        $tag->timecreated = time();
        $tag->timemodified = time();
        $tagid = $DB->insert_record(self::$table, $tag);
        return $tagid;
    }

    /**
     * Update an existing tag.
     *
     * @param  object    $tag The tag object to update.
     * @throws Exception If the tag is invalid.
     */
    public static function update_tag(object $tag): void
    {
        global $DB;
        if (!self::is_valid($tag->name)) {
            throw new Exception('Invalid tag name');
        }
        $tag->timemodefied = time();
        $DB->update_record(self::$table, $tag);
    }

    /**
     * Delete a tag by its ID.
     *
     * @param int $tagid The ID of the tag to delete.
     */
    public static function delete_tag(int $tagid): void
    {
        global $DB;
        $DB->delete_records(self::$table, ['id' => $tagid]);
    }

    /**
     * Assign a tag to a component
     *
     * @param  string $component The component to assign the tag to.
     * @param  int    $instance The instance of the component.
     * @param  int    $tagid The ID of the tag to assign.
     * @return bool
     */
    public static function assign_tag_to_component(string $component, int $instance, int $tagid) {
        return Context::insert_context($component, $instance, 'tag', $tagid);
    }

    /**
     * Get tags for a component
     *
     * @param  string    $component The component to get the tags for.
     * @param  int       $instance The instance of the component.
     * @return array
     * @throws Exception If the tag is invalid.
     */
    public static function get_tags_for_component(string $component, int $instance) {
        if (!$contexts = Context::get_contexts_by_component($component, $instance, 'tag')) {
            return [];
        }
        return array_map(function ($context) {
            if (!$tag = self::get_tag($context->modifierinstance)) {
                throw new Exception('Invalid tag');
            }
            return $tag;
        }, $contexts);
    }

    /**
     * Remove a tag from a component
     *
     * @param  string $component The component to remove the tag from.
     * @param  int    $instance The instance of the component.
     * @param  int    $tagid The ID of the tag to remove.
     * @return bool
     */
    public static function remove_tag_from_component(string $component, int $instance, int $tagid) {
        $context = Context::get_context_by_full_data($component, $instance, 'tag', $tagid);
        return Context::delete_context($context->id);
    }

    /**
     * Update tags for a component
     *
     * @param  string $component The component to update the tags for.
     * @param  int    $instance The instance of the component.
     * @param  array  $tags The tags to update.
     * @return void
     */
    public static function update_tags(string $component, int $instance, array $tags) {
        $current_tags = self::get_tags_for_component($component, $instance);
        $current_tags = array_map(function ($tag) {
            return $tag->id;
        }, $current_tags);
        foreach ($current_tags as $tagid) {
            if (!in_array($tagid, $tags)) {
                self::remove_tag_from_component($component, $instance, $tagid);
            }
        }
        foreach ($tags as $tagid) {
            if (!in_array($tagid, $current_tags)) {
                self::assign_tag_to_component($component, $instance, $tagid);
            }
        }
    }

    /**
     * Calculate the weight of a tag
     *
     * @param  object $tag The tag to calculate the weight for.
     * @return float
     */
    public static function calculate_tag_weight($tag) {
        $contexts = Context::get_contexts_by_modifier('tag');
        // Get absolute weights for all tags
        $weights = [];
        foreach ($contexts as $context) {
            if (!array_key_exists($context->modifierinstance, $weights)) {
                $weights[$context->modifierinstance] = 0;
            }
            $weights[$context->modifierinstance]++;
        }
        // Get relative weight for the tag
        if (!array_key_exists($tag->id, $weights)) {
            return 0;
        }
        return round($weights[$tag->id] / count($contexts) * 100);
    }
}
