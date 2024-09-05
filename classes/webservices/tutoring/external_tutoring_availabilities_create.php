<?php

/**
 * external_tutoring_availabilities_create
 *
 * @package   local_digitalta
 * @copyright 2024 ADSDR-FUNIBER Scepter Team
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/local/digitalta/classes/tutors.php');

use local_digitalta\Tutors;

class external_tutoring_availabilities_create extends external_api
{

    public static function availabilities_create_parameters()
    {
        return new external_function_parameters(
            [
                'userid' => new external_value(PARAM_INT, 'User id', VALUE_REQUIRED),
                'day' => new external_value(PARAM_TEXT, 'Day', VALUE_REQUIRED),
                'timefrom' => new external_value(PARAM_TEXT, 'Time from', VALUE_REQUIRED),
                'timeto' => new external_value(PARAM_TEXT, 'Time to', VALUE_REQUIRED)
            ]
        );
    }

    public static function availabilities_create($userid, $day, $timefrom, $timeto)
    {
        try {
            $availability = Tutors::availability_create($userid, $day, $timefrom, $timeto);
        } catch (\Exception $e) {
            throw new moodle_exception('error_creating_tutor_availability', 'local_digitalta', null, $e->getMessage());
        }
        return [
            'id' => $availability->id,
            'userid' => $availability->userid,
            'day' => $availability->day,
            'timefrom' => $availability->timefrom,
            'timeto' => $availability->timeto,
            'timecreated' => $availability->timecreated
        ];
    }

    public static function availabilities_create_returns()
    {
        return new external_multiple_structure(
            new external_single_structure(
                array(
                    'id' => new external_value(PARAM_INT, 'Tutor availability ID'),
                    'userid' => new external_value(PARAM_INT, 'User ID'),
                    'day' => new external_value(PARAM_TEXT, 'Day'),
                    'timefrom' => new external_value(PARAM_TEXT, 'Time from'),
                    'timeto' => new external_value(PARAM_TEXT, 'Time to'),
                    'timecreated' => new external_value(PARAM_INT, 'Time created')
                )
            )
        );
    }
}
