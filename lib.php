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
 * Library of functions for the local_digitalta plugin.
 *
 * @package   local_digitalta
 * @copyright 2024 ADSDR-FUNIBER Scepter Team
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once(__DIR__ . './../../config.php');

/**
 * Serve the files from the myplugin file areas.
 *
 * @param  stdClass $course The course object
 * @param  stdClass $cm The course module object
 * @param  stdClass $context The context
 * @param  string   $filearea The name of the file area
 * @param  array    $args Extra arguments (itemid, path)
 * @param  bool     $forcedownload Whether or not force download
 * @param  array    $options Additional options affecting the file serving
 * @return bool     If the file not found, just send the file otherwise and do not return anything
 */
function local_digitalta_pluginfile($course, $cm, $context, $filearea, $args, $forcedownload, array $options = [])
{
    if ($context->contextlevel !== CONTEXT_SYSTEM) {
        return false;
    }
    $itemid = array_shift($args);
    $filename = array_pop($args);
    $filepath = (empty($args)) ? '/' : '/' . implode('/', $args) . '/';
    $fs = get_file_storage();
    if (!$file = $fs->get_file($context->id, 'local_digitalta', $filearea, $itemid, $filepath, $filename)) {
        return false;
    }
    send_stored_file($file, 0, 0, $forcedownload, $options);
}
