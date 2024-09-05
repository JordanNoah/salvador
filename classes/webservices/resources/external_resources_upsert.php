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
 * WebService to upsert a resource
 *
 * @package   local_digitalta
 * @copyright 2024 ADSDR-FUNIBER Scepter Team
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/local/digitalta/classes/resource.php');
require_once($CFG->dirroot . '/local/digitalta/classes/resources.php');

use local_digitalta\Resource;
use local_digitalta\Resources;

/**
 * This class is used to upsert a resource
 *
 * @copyright 2024 ADSDR-FUNIBER Scepter Team
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class external_resources_upsert extends external_api
{
    /**
     * Returns the description of the external function parameters
     *
     * @return external_function_parameters The external function parameters
     */
    public static function resources_upsert_parameters()
    {
        return new external_function_parameters(
            [
                'id' => new external_value(PARAM_INT, 'Resource identifier', VALUE_DEFAULT, 0),
                'name' => new external_value(PARAM_TEXT, 'Resource name'),
                'description' => new external_value(PARAM_RAW, 'Resource description'),
                'type' => new external_value(PARAM_INT, 'Resource type'),
                'format' => new external_value(PARAM_TEXT, 'Resource format', VALUE_DEFAULT, 'Link'),
                'path' => new external_value(PARAM_TEXT, 'Resource path'),
                'lang' => new external_value(PARAM_TEXT, 'Resource language'),
                'themes' => new external_multiple_structure(
                    new external_value(PARAM_INT, 'Theme ID'), 'Themes' , VALUE_DEFAULT, []
                ),
                'tags' => new external_multiple_structure(
                    new external_value(PARAM_INT, 'Tag ID'), 'Tags' , VALUE_DEFAULT, []
                )
            ]
        );
    }

    /**
     * Upsert resource
     *
     * @param  int    $id          Resource identifier
     * @param  string $name        Resource name
     * @param  string $description Resource description
     * @param  int    $type        Resource type
     * @param  string $format      Resource format
     * @param  string $path        Resource path
     * @param  string $lang        Resource language
     * @param  array  $themes      Resource themes
     * @param  array  $tags        Resource tags
     * @return array  Array of resources
     */
    public static function resources_upsert($id = 0, $name, $description, $type, $format = 'Link', $path, $lang, $themes = [], $tags = [])
    {
        global $USER;

        $resource              = new Resource();
        $resource->id          = $id;
        $resource->name        = $name;
        $resource->description = $description;
        $resource->type        = $type;
        $resource->format      = Resources::get_format_by_name($format)->id;
        $resource->path        = $path;
        $resource->lang        = $lang;
        $resource->userid      = $USER->id;
        $resource->themes      = $themes;
        $resource->tags        = $tags;

        if (!$resourceid = Resources::upsert_resource($resource)) {
            return [
                'result' => false,
                'error' => 'Error saving resource'
            ];
        }

        return [
            'result' => true,
            'resourceid' => $resourceid
        ];
    }

    public static function resources_upsert_returns()
    {
        return new external_single_structure(
            [
                'result' => new external_value(PARAM_BOOL, 'Result'),
                'resourceid' => new external_value(PARAM_INT, 'Resource ID' , VALUE_OPTIONAL),
                'error' => new external_value(PARAM_RAW, 'Error message' , VALUE_OPTIONAL),
            ]
        );
    }
}
