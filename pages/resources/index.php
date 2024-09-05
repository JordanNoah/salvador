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
 * Repository index page
 *
 * @package   local_digitalta
 * @copyright 2024 ADSDR-FUNIBER Scepter Team
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once (__DIR__ . '/../../../../config.php');
require_once($CFG->dirroot . '/local/digitalta/classes/resources.php');
require_once($CFG->dirroot . '/local/digitalta/classes/utils/filterutils.php');
require_once($CFG->dirroot . '/local/digitalta/locallib.php');

require_login();

use local_digitalta\Resources;
use local_digitalta\utils\FilterUtils;

$pagetitle = get_string('resources:title', 'local_digitalta');

$PAGE->set_url(new moodle_url('/local/digitalta/pages/resources/index.php'));
$PAGE->set_context(context_system::instance());
$PAGE->set_title($pagetitle);
$PAGE->requires->js_call_amd('local_digitalta/reactions/main', 'init');

// Get the resources
$resources = Resources::get_resources();
$resources = array_map(function ($resource) {
    [$resource->type, $resource->type_simplified] =
        local_digitalta_get_element_translation(
            'resource_type',
            Resources::get_type($resource->type)->name);
    return $resource;
}, $resources);

echo $OUTPUT->header();

$template_context = [
    'title' => $pagetitle,
    'component' => 'resource',
    'resources' => [
        'data' => $resources,
    ]
];

$template_context = FilterUtils::apply_filters($template_context);

echo $OUTPUT->render_from_template('local_digitalta/resources/dashboard/dashboard', $template_context);

echo $OUTPUT->footer();
