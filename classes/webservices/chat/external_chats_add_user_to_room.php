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
class external_chats_add_user_to_room extends external_api
{
    // SERVICE : local_digitalta_chats_add_user_to_room
    public static function chats_add_user_to_room_parameters()
    {
        return new external_function_parameters(
            array(
                'chatid' => new external_value(PARAM_INT, 'ID'),
                'userid' => new external_value(PARAM_INT, 'User ID')
            )
        );
    }

    public static function chats_add_user_to_room($chatid, $userid)
    {
        $is = Chat::chats_add_user_to_room($chatid, $userid);

        return [
            'result' => $is,
        ];
    }

    public static function chats_add_user_to_room_returns()
    {
        return new external_single_structure(
            [
                'result' => new external_value(PARAM_BOOL, 'Result'),
                'error' => new external_value(PARAM_RAW, 'Error message', VALUE_OPTIONAL)
            ]
        );
    }
}
