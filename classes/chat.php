<?php

/**
 * Chat class
 *
 * @package   local_digitalta
 * @copyright 2024 ADSDR-FUNIBER Scepter Team
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_digitalta;

defined('MOODLE_INTERNAL') || die();

use stdClass;
use Exception;

class Chat
{

    private static $table_chat_room = 'digitalta_chat';
    private static $table_chat_messages = 'digitalta_chat_messages';
    private static $table_chat_users = 'digitalta_chat_users';


    /**
     * Create a chat room
     *
     * @param int $experience Experience level
     * @return stdClass
     */
    public static function create_chat_room($experience = 0): stdClass
    {
        global $DB;
        $chat_room = new stdClass();
        $chat_room->experience = $experience;
        $chat_room->timecreated = time();
        $chat_room->timemodified = time();
        $chat_room->id = $DB->insert_record(self::$table_chat_room, $chat_room);
        return $chat_room;
    }

    /**
     * Get a chat room by ID
     *
     * @param int $id Chat room ID
     * @return stdClass|null
     */
    public static function get_chat_room($id): ?stdClass
    {
        global $DB;
        return $DB->get_record(self::$table_chat_room, array('id' => $id));
    }

    /**
     * Get a chat room by experience
     *
     * @param int $experienceid Experience ID
     * @return stdClass|null
     */
    public static function get_chat_room_by_experience($experienceid): ?stdClass
    {
        global $DB;
        $chat = $DB->get_record(self::$table_chat_room, array('experienceid' => $experienceid));
        return $chat ? $chat : null;
    }

    /**
     * Add a user to a chat room
     *
     * @param int $chat_room_id Chat room ID
     * @param int $user_id User ID
     * @return stdClass
     */
    public static function chats_add_user_to_room($chat_room_id, $user_id): bool
    {
        global $DB;
        $chat_user = new stdClass();
        $chat_user->chat_room_id = $chat_room_id;
        $chat_user->user_id = $user_id;
        $chat_user->timecreated = time();
        $chat_user->timemodified = time();
        if(!$chat_user->id = $DB->insert_record(self::$table_chat_users, $chat_user)){
            return false;
        }
        return true;
    }

    /**
     * Get users in a chat room
     *
     * @param int $chat_room_id Chat room ID
     * @return array
     */
    public static function get_chat_users($chat_room_id): array
    {
        global $DB;
        return $DB->get_records(self::$table_chat_users, array('chat_room_id' => $chat_room_id));
    }

    /**
     * Add a message to a chat room
     *
     * @param int $chat_room_id Chat room ID
     * @param int $user_id User ID
     * @param string $message Message content
     * @return stdClass
     */
    public static function chats_add_message_to_chat_room($chat_room_id, $user_id, $message): bool
    {
        global $DB;
        if(!self::is_user_in_chat_room($chat_room_id, $user_id)){ // Check if user is in chat room (throws exception if not
            throw new Exception('User is not in chat room');
        }

        $chat_message = new stdClass();
        $chat_message->chatid = $chat_room_id;
        $chat_message->userid = $user_id;
        $chat_message->message = $message;
        $chat_message->timecreated = time();
        $chat_message->timemodified = time();
        $chat_message->id = $DB->insert_record(self::$table_chat_messages, $chat_message);
        if(!$chat_message->id){
            throw new Exception('Error inserting chat message');
        }
        return true;
    }

    /**
     * Get messages in a chat room
     *
     * @param int $chat_room_id Chat room ID
     * @param int|null $limit Limit of messages to retrieve
     * @param int $offset Offset for pagination
     * @return array
     */
    public static function get_chat_messages(int $chat_room_id, int $userid = 0, ?int $limit = null, int $offset = 0): array
    {
        global $DB, $USER;

        if($userid == 0){
            $userid = $USER->id;
        }

        if (!self::is_user_in_chat_room($chat_room_id, $userid)) {
            throw new Exception('User is not in chat room');
        }

        $sql = "SELECT * FROM {" . self::$table_chat_messages . "} WHERE chatid = ?";
        if (!is_null($limit)) {
            $sql .= " LIMIT $limit OFFSET $offset";
        }
        $messages = array_values($DB->get_records_sql($sql, array($chat_room_id)));

        return self::prepare_messages_output($messages);
    }

    /**
     * Prepare messages output
     * @param array $messages Messages as it comes from the database
     * @return array
     */
    public static function prepare_messages_output($messages): array
    {
        global $USER;
        $output = [];
        foreach ($messages as $message) {
            $is_mine = $message->userid == $USER->id ? true : false;
            $output[] = [
                'id' => $message->id,
                'chatid' => $message->chatid,
                'userid' => $message->userid,
                'message' => $message->message,
                'timecreated' => date("H:i", strtotime($message->timecreated)),
                'timemodified' => $message->timemodified,
                'is_mine' => $is_mine
            ];
        }
        return $output;
    }


    /**
     * Get messages in a chat room by user
     *
     * @param int $chat_room_id Chat room ID
     * @param int $user_id User ID
     * @return array
     */
    public static function get_chat_messages_by_user($chat_room_id, $user_id): array
    {
        global $DB;
        return $DB->get_records(self::$table_chat_messages, array('chat_room_id' => $chat_room_id, 'user_id' => $user_id));
    }

    /**
     * Check if a user is in a chat room
     *
     * @param int $chat_room_id Chat room ID
     * @param int $user_id User ID
     * @return bool
     */
    public static function is_user_in_chat_room($chat_room_id, $user_id): bool
    {
        global $DB;
        return $DB->record_exists(self::$table_chat_users, array('chatid' => $chat_room_id, 'userid' => $user_id));
    }

    /**
     * Get all chat rooms for a user
     *
     * @param int $userid User ID
     * @param int $experienceid Experience ID
     * @return array
     */
    public static function chats_get_rooms($userid = null , $experienceid = null): array
    {
        global $DB, $USER;

        if(is_null($userid)){
            $userid = $USER->id;
        }

        $sql = "SELECT
        *
        FROM
             {digitalta_chat_users}  cu
        INNER JOIN  {digitalta_chat}  cr
        ON
            cu.chatid = cr.id
        WHERE
            cu.userid = ?";

        if($experienceid){
            $sql .= " AND cr.experienceid = ? LIMIT 1";
        }


        $chat_rooms = array_values($DB->get_records_sql($sql, array($userid, $experienceid)));
        $chat_rooms = self::set_chat_names($chat_rooms);
        
        return $chat_rooms;
    }

    /**
     * Set chat names
     */
    public static function set_chat_names($chat_rooms): array
    {
        global $DB;
        $chat_rooms_with_names = [];
        foreach ($chat_rooms as $chat_room) {
            $chat_room->name = '';
            if($chat_room->experienceid){
                $experience = $DB->get_record('digitalta_experiences', array('id' => $chat_room->experienceid));   
                $chat_room->name = $experience->title;
            }else{
                $chat_users = $DB->get_records(self::$table_chat_users, array('chatid' => $chat_room->id));
                $text = 'Chat with';
                foreach ($chat_users as $chat_user) {
                    $user = $DB->get_record('user', array('id' => $chat_user->userid));
                    $text .= ' ' . $user->firstname . ' ' . $user->lastname. ',';
                }
                $chat_room->name = $text;
            }
            $chat_rooms_with_names[] = $chat_room;
        }
        return $chat_rooms_with_names;
    }

}
