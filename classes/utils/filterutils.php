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
 * Filter utils
 *
 * @package   local_digitalta
 * @copyright 2024 ADSDR-FUNIBER Scepter Team
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_digitalta\utils;

/**
 * This class is used to operate with filters
 *
 * @copyright 2024 ADSDR-FUNIBER Scepter Team
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class FilterUtils
{
    /**
     * Apply filter to object, array or strings
     * 
     * @param mixed $filterable_target
     * @param int $contextid
     * @param string $format
     * @param array $options
     * @return void
     */
    public static function apply_filters($filterable_target, $contextid = 1, $format = FORMAT_HTML, $options = []) {
        // Ensure filters are always enabled
        $options['filter'] = true;
    
        // Arrays
        if (is_array($filterable_target)) {
            foreach ($filterable_target as $key => &$value) {
                if (stripos($key, 'url') === false) {
                    $value = self::apply_filters($value, $contextid, $format, $options);
                }
            }
            return $filterable_target;
        // Objects
        } elseif (is_object($filterable_target)) {
            foreach ($filterable_target as $property => &$value) {
                if (stripos($property, 'url') === false) {
                    $filterable_target->$property = self::apply_filters($value, $contextid, $format, $options);
                }
            }
            return $filterable_target;
        // Strings
        } elseif (is_string($filterable_target)) {
            // TODO: Deactivated temporarily due to unexpected behavior
            //return format_text($filterable_target, $format, $options, $contextid);
            return $filterable_target;
        // Other
        } else {
            return $filterable_target;
        }
    }
}
