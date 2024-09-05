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
 * WebService to get the resources assigned to a component
 *
 * @package   local_digitalta
 * @copyright 2024 ADSDR-FUNIBER Scepter Team
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/local/digitalta/classes/resources.php');
require_once($CFG->dirroot . '/local/digitalta/classes/tags.php');
require_once($CFG->dirroot . '/local/digitalta/classes/themes.php');

use local_digitalta\Resources;
use local_digitalta\Tags;
use local_digitalta\Themes;

/**
 * This class is used to get the resources assigned to a component
 *
 * @copyright 2024 ADSDR-FUNIBER Scepter Team
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class external_resources_get_assignments_for_component extends external_api
{
    /**
     * Returns the description of the external function parameters
     *
     * @return external_function_parameters The external function parameters
     */
    public static function resources_get_assignments_for_component_parameters()
    {
        return new external_function_parameters(
            [
                'component' => new external_value(PARAM_TEXT, 'Component'),
                'componentinstance' => new external_value(PARAM_INT, 'Component instance')
            ]
        );
    }

    /**
     * Get resources
     *
     * @return array  Array of resources
     */
    public static function resources_get_assignments_for_component($component, $componentinstance)
    {
        // Get the assignments
        $assignments = Resources::get_assignments_for_component($component, $componentinstance);

        // Check if the assignments were found
        if (!$assignments) {
            return [
                'result' => false,
                'error' => 'Resources not found',
            ];
        }

        // Get the resources
        $resources = [];
        foreach ($assignments as $assignment) {
            $resources[] = Resources::get_resource($assignment->resourceid);
        }

        // Check if the resources were found
        if (!$resources) {
            return [
                'result' => false,
                'error' => 'No resources found',
            ];
        }

        // Format the results
        $resources = array_map(function ($resource) {
            // Return the format as text
            $resource->format = Resources::get_format($resource->format)->name;
            // Get the themes for the resource
            $themes = Themes::get_themes_for_component('resource', $resource->id);
            $resource->themes = array_map(function ($theme) {
                return (object) [
                    'id' => $theme->id,
                    'name' => $theme->name
                ];
            }, $themes);
            // Get the tags for the resource
            $tags = Tags::get_tags_for_component('resource', $resource->id);
            $resource->tags = array_map(function ($tag) {
                return (object) [
                    'id' => $tag->id,
                    'name' => $tag->name
                ];
            }, $tags);
            return $resource;
        }, $resources);

        // Return the results
        return [
            'result' => true,
            'resources' => $resources
        ];
    }

    /**
     * Returns the description of the external function return value
     *
     * @return external_single_structure The external function return value
     */
    public static function resources_get_assignments_for_component_returns()
    {
        return new external_single_structure(
            [
                'result' => new external_value(PARAM_BOOL, 'Result'),
                'resources' => new external_multiple_structure(
                    new external_single_structure(
                        [
                            'id' => new external_value(PARAM_INT, 'ID'),
                            'userid' => new external_value(PARAM_INT, 'User ID'),
                            'name' => new external_value(PARAM_TEXT, 'Name'),
                            'description' => new external_value(PARAM_RAW, 'Description'),
                            'type' => new external_value(PARAM_INT, 'Type'),
                            'format' => new external_value(PARAM_TEXT, 'Format'),
                            'path' => new external_value(PARAM_TEXT, 'Path'),
                            'lang' => new external_value(PARAM_TEXT, 'Language'),
                            'timecreated' => new external_value(PARAM_INT, 'Time created'),
                            'timemodified' => new external_value(PARAM_INT, 'Time modified'),
                            'tags' => new external_multiple_structure(
                                new external_single_structure(
                                    [
                                        'id' => new external_value(PARAM_INT, 'ID'),
                                        'name' => new external_value(PARAM_TEXT, 'Name')
                                    ]
                                ), 'Tags', VALUE_OPTIONAL
                            ),
                            'themes' => new external_multiple_structure(
                                new external_single_structure(
                                    [
                                        'id' => new external_value(PARAM_INT, 'ID'),
                                        'name' => new external_value(PARAM_TEXT, 'Name')
                                    ]
                                ), 'themes', VALUE_OPTIONAL
                            ),
                        ]
                    ), 'Resources', VALUE_OPTIONAL
                ),
                'error' => new external_value(PARAM_RAW, 'Error message' , VALUE_OPTIONAL)
            ]
        );
    }
}
