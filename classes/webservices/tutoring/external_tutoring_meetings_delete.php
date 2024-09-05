<?php

/**
 * external_meetings_delete
 *
 * @package   local_digitalta
 * @copyright 2024 ADSDR-FUNIBER Scepter Team
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/local/digitalta/classes/googlemeet/helper.php');

use local_digitalta\helper;

class external_tutoring_meetings_delete extends external_api
{

    public static function meetings_delete_parameters()
    {
        return new external_function_parameters(
            [
                'chatid' => new external_value(PARAM_INT, 'Chat id', VALUE_REQUIRED)
            ]
        );
    }

    public static function meetings_delete($chatid)
    {
        try {
            $deleted_meeting = helper::delete_googlemeet_record($chatid);
            return $deleted_meeting;
        } catch (\Exception $e) {
            throw new moodle_exception('error_deleting_meeting', 'local_digitalta', null, $e->getMessage());
        }
    }

    public static function meetings_delete_returns()
    {
        return new external_value(PARAM_BOOL, 'Record found and deleted');
    }
}
