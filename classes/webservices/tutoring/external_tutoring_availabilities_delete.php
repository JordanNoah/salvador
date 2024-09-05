<?php

/**
 * external_tutoring_availabilities_delete
 *
 * @package   local_digitalta
 * @copyright 2024 ADSDR-FUNIBER Scepter Team
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/local/digitalta/classes/tutors.php');

use local_digitalta\Tutors;

class external_tutoring_availabilities_delete extends external_api
{

    public static function availabilities_delete_parameters()
    {
        return new external_function_parameters(
            [
                'id' => new external_value(PARAM_INT, 'Tutor availability id', VALUE_REQUIRED)
            ]
        );
    }

    public static function availabilities_delete($userid, $day, $timefrom, $timeto)
    {
        try {
            $availability = Tutors::availability_delete($userid, $day, $timefrom, $timeto);
            if (!$availability) {
                return false;
            }
        } catch (\Exception $e) {
            throw new moodle_exception('error_creating_tutor_availability', 'local_digitalta', null, $e->getMessage());
        }
        return true;
    }

    public static function availabilities_delete_returns()
    {
        return new external_value(PARAM_BOOL, 'True if the tutor availability was deleted');
    }
}
