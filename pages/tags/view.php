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
 * Tags view page
 *
 * @package   local_digitalta
 * @copyright 2024 ADSDR-FUNIBER Scepter Team
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__ . '/../../../../config.php');
require_once($CFG->dirroot . '/local/digitalta/classes/cases.php');
require_once($CFG->dirroot . '/local/digitalta/classes/context.php');
require_once($CFG->dirroot . '/local/digitalta/classes/experiences.php');
require_once($CFG->dirroot . '/local/digitalta/classes/resources.php');
require_once($CFG->dirroot . '/local/digitalta/classes/tags.php');
require_once($CFG->dirroot . '/local/digitalta/classes/themes.php');
require_once($CFG->dirroot . '/local/digitalta/classes/utils/filterutils.php');

require_login();

use local_digitalta\Cases;
use local_digitalta\Context;
use local_digitalta\Experiences;
use local_digitalta\Resources;
use local_digitalta\Tags;
use local_digitalta\Themes;
use local_digitalta\utils\FilterUtils;

$tagtype = required_param('type', PARAM_TEXT);
$tagid = required_param('id', PARAM_INT);

$PAGE->set_context(context_system::instance());
$PAGE->set_url(new moodle_url('/local/digitalta/pages/tags/index.php', ['type' => $tagtype, 'id' => $tagid]));

$themetag = ($tagtype == 'tag')
    ? Tags::get_tag($tagid)
    : Themes::get_theme($tagid);
if (!$themetag) {
    throw new moodle_exception('themestags:invalidthemetag', 'local_digitalta');
}
$pagetitle = ($tagtype == 'tag')
    ? get_string('concept:tag', 'local_digitalta')
    : get_string('concept:theme', 'local_digitalta');

$PAGE->set_title($pagetitle . ': ' . $themetag->name);

// Get the experiences
$experiences = Context::get_contexts_by_modifier($tagtype, $tagid, 'experience');
$experiences = array_map(function($key, $context) {
    $experience = Experiences::get_experience($context->componentinstance);
    return $experience;
}, array_keys($experiences), $experiences);

// Get the cases
$cases = Context::get_contexts_by_modifier($tagtype, $tagid, 'case');
$cases = array_map(function($key, $context) {
    $case = Cases::get_case($context->componentinstance);
    return $case;
}, array_keys($cases), $cases);

// Get the resources
$resources = Context::get_contexts_by_modifier($tagtype, $tagid, 'resource');
$resources = array_map(function($key, $context) {
    $resource = Resources::get_resource($context->componentinstance);
    return $resource;
}, array_keys($resources), $resources);

// Get the users
$users = Context::get_contexts_by_modifier($tagtype, $tagid, 'user');

echo $OUTPUT->header();

$template_context = [
    'title' => $pagetitle,
    'tag' => [
        'id' => $themetag->id,
        'name' => $themetag->name
    ],
    'experiences' => [
        'data' => $experiences,
        'viewurl' => $CFG->wwwroot . '/local/digitalta/pages/experiences/view.php?id='
    ],
    'cases' => [
        'data' => $cases,
        'viewurl' => $CFG->wwwroot . '/local/digitalta/pages/cases/view.php?id='
    ],
    'resources' => [
        'data' => $resources
    ],
    'users' => [
        'data' => $users,
        'viewurl' => $CFG->wwwroot . '/local/digitalta/pages/profile/index.php?id='
    ]
];

$template_context = FilterUtils::apply_filters($template_context);

echo $OUTPUT->render_from_template('local_digitalta/tags/view/view', $template_context);

echo $OUTPUT->footer();
