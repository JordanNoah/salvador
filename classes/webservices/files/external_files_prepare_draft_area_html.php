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
 * WebService to prepare the HTML for a file upload area
 *
 * @package   local_digitalta
 * @copyright 2024 ADSDR-FUNIBER Scepter Team
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once($CFG->dirroot . '/local/digitalta/classes/files/filemanagerhandler.php');

use local_digitalta\file\FileManagerHandler;

/**
 * This class is used to upload a file from draft area
 *
 * @copyright 2024 ADSDR-FUNIBER Scepter Team
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class external_files_prepare_draft_area_html extends external_api
{
    /**
     * Returns the description of the external function parameters
     *
     * @return external_function_parameters The external function parameters
     */
    public static function prepare_draft_area_html_parameters()
    {
        return new external_function_parameters(
            [
                'filearea' => new external_value(PARAM_TEXT, 'File area'),
                'component' => new external_value(PARAM_TEXT, 'Component', VALUE_OPTIONAL),
                'filecontextid' => new external_value(PARAM_INT, 'File context id', VALUE_OPTIONAL),
            ]
        );
    }

    /**
     * Prepares the HTML for a file upload area
     *
     * @param  string $filearea      File area
     * @param  string $component     Component
     * @param  int    $filecontextid File context id
     * @return string The draft area HTML
     */
    public static function prepare_draft_area_html($filearea, $component = "local_digitalta", $filecontextid = 1)
    {
        $fileManagerHandler = new FileManagerHandler();
        if (!$html = $fileManagerHandler->prepare_draft_area_html($filecontextid, $component, $filearea)) {
            return [
                'result' => true,
                'error' => 'Error preparing draft area HTML',
            ];
        }
        return [
            'result' => false,
            'html' => $html
        ];
    }

    /**
     * Returns the description of the external function return value
     *
     * @return external_single_structure The external function return value
     */
    public static function prepare_draft_area_html_returns()
    {
        return new external_single_structure(
            [
                'result' => new external_value(PARAM_BOOL, 'Result'),
                'html' => new external_value(PARAM_RAW, 'Draft area HTML', VALUE_OPTIONAL),
                'error' => new external_value(PARAM_TEXT, 'Error', VALUE_OPTIONAL)
            ]
        );
    }
}
