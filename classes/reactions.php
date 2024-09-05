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
 * Reactions class
 *
 * @package   local_digitalta
 * @copyright 2024 ADSDR-FUNIBER Scepter Team
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_digitalta;

use stdClass;

/**
 * This class is used to manage reactions
 *
 * @copyright 2024 ADSDR-FUNIBER Scepter Team
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class Reactions
{
    /** @var string The table name for the comments. */
    private static $table_comments = 'digitalta_comments';

    /** @var string The table name for the likes. */
    private static $table_likes = 'digitalta_likes';

    /** @var string The table name for the reports. */
    private static $table_reports = 'digitalta_reports';

    /**
     * Get all reactions for a specific component
     *
     * @param  int   $component Component identifier
     * @param  int   $componentinstance Component instance identifier
     * @return array An array of records
     */
    public static function get_reactions_for_render_component(int $component, int $componentinstance): array
    {
        global $USER;
        $likes = self::get_likes_for_component($component, $componentinstance);
        $dislikes = self::get_dislikes_for_component($component, $componentinstance);
        $comments = self::get_comments_for_component($component, $componentinstance);
        $reports = self::get_reports_for_component($component, $componentinstance);

        return [
            'likes' => [
                'count' => count($likes),
                'data' => $likes,
                'isactive' => self::user_reacted($likes, $USER->id),
            ],
            'dislikes' => [
                'count' => count($dislikes),
                'data' => $dislikes,
                'isactive' => self::user_reacted($dislikes, $USER->id)
            ],
            'comments' => [
                'count' => count($comments),
                'data' => $comments
            ],
            'reports' => [
                'count' => count($reports),
                'data' => $reports,
                'isactive' => self::user_reacted($reports, $USER->id)
            ]
        ];
    }

    /**
     * Check if the current user has reacted to a specific component
     * 
     * @param  array $reactions The reaction data
     * @param  int   $userid The user identifier
     * @return bool  True if the user has reacted to the experience
     */
    public static function user_reacted(array $reactions, int $userid): bool
    {
        foreach ($reactions as $reaction) {
            if ($reaction->userid == $userid) {
                return true;
            }
        }
        return false;
    }

    /**
     * Get all 'like' reactions for a specific component
     *
     * @param  int   $component ID of the component
     * @param  int   $componentinstance ID of the component instance
     * @param  int   $userid The user identifier
     * @return array Returns an array of records
     */
    public static function get_likes_for_component(int $component, int $componentinstance, int $userid = null): array
    {
        global $DB;
        $conditions = [
            'component' => $component,
            'componentinstance' => $componentinstance,
            'reactiontype' => 1
        ];
        if ($userid) {
            $conditions['userid'] = $userid;
        }
        return $DB->get_records(self::$table_likes, $conditions);
    }

    /**
     * Get all 'dislike' reactions for a specific component
     *
     * @param  int   $component ID of the component
     * @param  int   $componentinstance ID of the component instance
     * @param  int   $userid The user identifier
     * @return array Returns an array of records
     */
    public static function get_dislikes_for_component(int $component, int $componentinstance, int $userid = null): array
    {
        global $DB;
        $conditions = [
            'component' => $component,
            'componentinstance' => $componentinstance,
            'reactiontype' => 0
        ];
        if ($userid) {
            $conditions['userid'] = $userid;
        }
        return $DB->get_records(self::$table_likes, $conditions);
    }

    /**
     * Get all comments for a specific component
     *
     * @param  int   $component ID of the component
     * @param  int   $componentinstance ID of the component instance
     * @param  int   $userid The user identifier
     * @return array Returns an array of records
     */
    public static function get_comments_for_component(int $component, int $componentinstance, int $userid = null): array
    {
        global $DB;
        $conditions = [
            'component' => $component,
            'componentinstance' => $componentinstance
        ];
        if ($userid) {
            $conditions['userid'] = $userid;
        }
        return $DB->get_records(self::$table_comments, $conditions);
    }

    /**
     * Get all reports for a specific component
     *
     * @param  int   $component ID of the component
     * @param  int   $componentinstance ID of the component instance
     * @param  int   $userid The user identifier
     * @return array Returns an array of records
     */
    public static function get_reports_for_component(int $component, int $componentinstance, int $userid = null): array
    {
        global $DB;
        $conditions = [
            'component' => $component,
            'componentinstance' => $componentinstance
        ];
        if ($userid) {
            $conditions['userid'] = $userid;
        }
        return $DB->get_records(self::$table_reports, $conditions);
    }

    /**
     * Get the most liked components of a type
     *
     * @param  int   $component The component identifier
     * @param  int   $limit The number of components to return
     * @return array Returns an array of records
     */
    public static function get_most_liked_component(int $component, int $limit): array
    {
        global $DB;
        $component = Components::get_component($component);
        $most_liked = $DB->get_records_sql("SELECT mdlk.componentinstance,
                                                   COUNT(mdlk.id) as likes
                                              FROM {". self::$table_likes ."} mdlk
                                             WHERE mdlk.component = :component
                                               AND mdlk.reactiontype = 1
                                          GROUP BY componentinstance
                                          ORDER BY likes DESC",
            ['component' => $component->id],
            0,
            $limit);
        usort($most_liked, function($a, $b) {
            return $a->likes < $b->likes;
        });
        return $most_liked;
    }

    /**
     * Toggle like/dislike for a specific component
     *
     * @param  int      $component The component identifier
     * @param  int      $componentinstance The component instance identifier
     * @param  int      $reactiontype The reaction type
     * @param  int      $userid The user identifier
     * @return int|bool The identifier of the record if it was added or updated, -1 if it was deleted, false if it failed
     */
    public static function toggle_like_dislike(int $component, int $componentinstance, int $reactiontype, int $userid)
    {
        global $DB;
        $conditions = [
            'component' => $component,
            'componentinstance' => $componentinstance,
            'userid' => $userid
        ];
        $existing_reaction = $DB->get_record(self::$table_likes, $conditions);
        if ($existing_reaction) {
            if ($existing_reaction->reactiontype == $reactiontype) {
                if (!$DB->delete_records(self::$table_likes, $conditions)) {
                    return false;
                }
                return -1;
            } else {
                $existing_reaction->reactiontype = $reactiontype;
                $existing_reaction->timemodified = time();
                if (!$DB->update_record(self::$table_likes, $existing_reaction)) {
                    return false;
                }
                return $existing_reaction->id;
            }
        } else {
            $reaction                    = new stdClass();
            $reaction->component         = $component;
            $reaction->componentinstance = $componentinstance;
            $reaction->userid            = $userid;
            $reaction->reactiontype      = $reactiontype;
            $reaction->timecreated       = time();
            $reaction->timemodified      = time();
            if (!$reaction->id = $DB->insert_record(self::$table_likes, $reaction)) {
                return false;
            }
            return $reaction->id;
        }
    }

    /**
     * Add a comment to a specific component
     *
     * @param  int      $component The component identifier
     * @param  int      $componentinstance The component instance identifier
     * @param  string   $comment The comment text
     * @param  int      $userid The user identifier
     * @return int|bool The identifier of the record if it was added, false if it failed
     */
    public static function add_comment(int $component, int $componentinstance, string $comment, int $userid)
    {
        global $DB;
        $record                    = new stdClass();
        $record->component         = $component;
        $record->componentinstance = $componentinstance;
        $record->userid            = $userid;
        $record->comment           = $comment;
        $record->timecreated       = time();
        $record->timemodified      = time();

        if (!$record->id = $DB->insert_record(self::$table_comments, $record)) {
            return false;
        }
        return $record->id;
    }

    /**
     * Delete a comment
     *
     * @param  int      $commentid The comment identifier
     * @return bool     True if the comment was deleted, false if it failed
     */
    public static function delete_comment(int $commentid)
    {
        global $DB;
        $conditions = [
            'id' => $commentid
        ];
        if (!$DB->delete_records(self::$table_comments, $conditions)) {
            return false;
        }
        return true;
    }

    /**
     * Toggle report for a specific component
     *
     * @param  int      $component The component identifier
     * @param  int      $componentinstance The component instance identifier
     * @param  string   $description The report description
     * @param  int      $userid The user identifier
     * @return int|bool The identifier of the record if it was added, -1 if it was deleted, false if it failed
     */
    public static function toggle_report(int $component, int $componentinstance, string $description = null, int $userid)
    {
        global $DB;
        $conditions = [
            'component' => $component,
            'componentinstance' => $componentinstance,
            'userid' => $userid
        ];
        if ($existing_report = $DB->get_record(self::$table_reports, $conditions)) {
            if (!$DB->delete_records(self::$table_reports, $conditions)) {
                return false;
            }
            return -1;
        } else {
            $report                    = new stdClass();
            $report->component         = $component;
            $report->componentinstance = $componentinstance;
            $report->userid            = $userid;
            $report->description       = $description;
            $report->timecreated       = time();
            $report->timemodified      = time();
            if (!$report->id = $DB->insert_record(self::$table_reports, $report)) {
                return false;
            }
            return $report->id;
        }
    }

    /**
     * Delete all reactions for a specific component
     *
     * @param  int $component The component identifier
     * @param  int $componentinstance The component instance identifier
     */
    public static function delete_all_reactions_for_component(int $component, int $componentinstance)
    {
        global $DB;
        $conditions = [
            'component' => $component,
            'componentinstance' => $componentinstance
        ];
        $DB->delete_records(self::$table_likes, $conditions);
        $DB->delete_records(self::$table_comments, $conditions);
        $DB->delete_records(self::$table_reports, $conditions);
    }
}
