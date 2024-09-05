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
 * Date utils
 *
 * @package   local_digitalta
 * @copyright 2024 ADSDR-FUNIBER Scepter Team
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_digitalta\utils;

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/lib/moodlelib.php');

/**
 * This class is used to operate with dates
 *
 * @copyright 2024 ADSDR-FUNIBER Scepter Team
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class DateUtils
{
    public static function time_elapsed_string(int $datetime, $full = false)
    {
        $now = new \DateTime();
        $ago = new \DateTime();
        $ago->setTimestamp($datetime);
        $diff = $now->diff($ago);

        $weeks = floor($diff->d / 7);
        $diff->d -= $weeks * 7;

        $parts = array();
        $time_units = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute'
        );

        foreach ($time_units as $key => $time) {
            $value = $key === 'w' ? $weeks : $diff->$key;
            if ($value > 0) {
                $parts[] = $value . ' ' . get_string(($value > 1 ? $time . 's' : $time), 'core', $value);
            }
        }

        if (!$parts) {
            return get_string('general:date_justnow', 'local_digitalta');
        }

        if (!$full) {
            $parts = array_slice($parts, 0, 1);
        }

        return get_string('general:date_timeago', 'local_digitalta', implode(', ', $parts));
    }
}
