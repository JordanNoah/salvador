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
 * WebService to get comments
 *
 * @package   local_digitalta
 * @copyright 2024 ADSDR-FUNIBER Scepter Team
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/local/digitalta/classes/components.php');
require_once($CFG->dirroot . '/local/digitalta/classes/reactions.php');
require_once($CFG->dirroot . '/local/digitalta/classes/utils/dateutils.php');

use local_digitalta\Components;
use local_digitalta\Reactions;
use local_digitalta\utils\DateUtils;

/**
 * This class is used to get comments
 *
 * @copyright 2024 ADSDR-FUNIBER Scepter Team
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class external_reactions_get_comments extends external_api
{
    /**
     * Returns the description of the external function parameters
     *
     * @return external_function_parameters The external function parameters
     */
    public static function reactions_get_comments_parameters()
    {
        return new external_function_parameters(
            [
                'component' => new external_value(PARAM_TEXT, 'Component'),
                'componentinstance' => new external_value(PARAM_INT, 'Component instance')
            ]
        );
    }

    /**
     * Gets comments
     *
     * @param  string $component Component
     * @param  int    $componentinstance Component instance
     * @return array  Array with the result and the comments
     */
    public static function reactions_get_comments($component, $componentinstance)
    {
        global $DB;

        $component = Components::get_component_by_name($component);
        if (!$comments = Reactions::get_comments_for_component($component->id, $componentinstance)) {
            return ['result' => false, 'error' => 'Error getting comments'];
        }
        $comments = array_map(function ($comment) use ($DB) {
            $return          = new \stdClass();
            $return->id      = $comment->id;
            $return->comment = $comment->comment;

            $return->created_raw = date('Y-m-d H:i:s', $comment->timecreated);
            $return->created     = DateUtils::time_elapsed_string($comment->timecreated);

            $user = $DB->get_record('user', ['id' => $comment->userid]);

            $return->user            = new \stdClass();
            $return->user->id        = $user->id;
            $return->user->username  = $user->username;
            $return->user->firstname = $user->firstname;
            $return->user->lastname  = $user->lastname;
            $return->user->fullname  = fullname($user);
            $return->user->email     = $user->email;

            return $return;
        }, $comments);

        return ['result' => true, 'comments' => $comments];
    }

    /**
     * Returns the description of the external function return value
     *
     * @return external_single_structure The external function return value
     */
    public static function reactions_get_comments_returns()
    {
        return new external_single_structure(
            [
                'result' => new external_value(PARAM_BOOL, 'Result'),
                'comments' => new external_multiple_structure(
                    new external_single_structure(
                        [
                            'id' => new external_value(PARAM_INT, 'ID'),
                            'user' => new external_single_structure(
                                [
                                    'id' => new external_value(PARAM_INT, 'ID'),
                                    'username' => new external_value(PARAM_TEXT, 'Username'),
                                    'firstname' => new external_value(PARAM_TEXT, 'First Name'),
                                    'lastname' => new external_value(PARAM_TEXT, 'Last Name'),
                                    'fullname' => new external_value(PARAM_TEXT, 'Full Name'),
                                    'email' => new external_value(PARAM_TEXT, 'Email'),
                                ]
                            ),
                            'comment' => new external_value(PARAM_RAW, 'Comment'),
                            'created' => new external_value(PARAM_TEXT, 'Time created'),
                            'created_raw' => new external_value(PARAM_TEXT, 'Time created raw')
                        ]
                    ), 'Comments', VALUE_OPTIONAL
                ),
                'error' => new external_value(PARAM_TEXT, 'Error message', VALUE_OPTIONAL)
            ]
        );
    }
}
