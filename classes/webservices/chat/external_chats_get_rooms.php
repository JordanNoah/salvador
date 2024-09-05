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
 * WebService chat services
 *
 * @package   local_digitalta
 * @copyright 2024 ADSDR-FUNIBER Scepter Team
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/local/digitalta/classes/chat.php');

use local_digitalta\Chat;

/**
 * This class is used to delete a context
 *
 * @copyright 2024 ADSDR-FUNIBER Scepter Team
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class external_chats_get_rooms extends external_api
{
    // SERVICE : local_digitalta_chats_get_rooms
    public static function chats_get_rooms_parameters()
    {
        return new external_function_parameters(
            array(
                'experienceid' => new external_value(PARAM_INT, 'experience ID' , VALUE_OPTIONAL, null),
            )
        );
    }

    public static function chats_get_rooms($experienceid = null)
    {
        $rooms = Chat::chats_get_rooms(null, $experienceid);

        return [
            'result' => true,
            'chatrooms' => $rooms
        ];
    }

    public static function chats_get_rooms_returns()
    {
        return new external_single_structure(
            [
                'result' => new external_value(PARAM_BOOL, 'Result'),
                'chatrooms' => new external_multiple_structure(
                    new external_single_structure(
                        [
                            'id' => new external_value(PARAM_INT, 'ID'),
                            'chatid' => new external_value(PARAM_INT, 'Chat ID'),
                            'userid' => new external_value(PARAM_INT, 'User ID'),
                            'experienceid' => new external_value(PARAM_INT, 'Experience ID'),
                            'name' => new external_value(PARAM_TEXT, 'Name'),
                            'timecreated' => new external_value(PARAM_INT, 'Time Created'),
                            'timemodified' => new external_value(PARAM_INT, 'Time Modified'),
                        ]
                    )
                ),
                'error' => new external_value(PARAM_RAW, 'Error message', VALUE_OPTIONAL)
            ]
        );
    }
}
