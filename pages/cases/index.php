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
 * Case repository page
 *
 * @package   local_digitalta
 * @copyright 2024 ADSDR-FUNIBER Scepter Team
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__ . '/../../../../config.php');
require_once($CFG->dirroot . '/local/digitalta/classes/cases.php');
require_once($CFG->dirroot . '/local/digitalta/classes/utils/filterutils.php');

require_login();

use local_digitalta\Cases;
use local_digitalta\utils\FilterUtils;

$pagetitle = get_string('cases:title', 'local_digitalta');

// Setea el título de la página
$PAGE->set_url(new moodle_url('/local/digitalta/pages/cases/index.php'));
$PAGE->set_context(context_system::instance());
$PAGE->set_title($pagetitle);
$PAGE->requires->js_call_amd('local_digitalta/reactions/main', 'init');

echo $OUTPUT->header();

// Get the cases
$publishedcases = Cases::get_cases(['status' => 1]);
$owncases = Cases::get_cases(['userid' => $USER->id]);
$cases = array_values(array_merge($publishedcases, $owncases));

// Get the user data
$user = get_complete_user_data('id', $USER->id);
$picture = new user_picture($user);
$picture->size = 101;
$user->imageurl = $picture->get_url($PAGE)->__toString();

$template_context = [
    'title' => $pagetitle,
    'component' => 'case',
    'cases' => [
        'data' => $cases,
        'viewurl' => $CFG->wwwroot . '/local/digitalta/pages/cases/view.php?id=',
        'manageurl' => $CFG->wwwroot . '/local/digitalta/pages/cases/manage.php?id=',
    ],
    'user' => $user,
    'createurl' => $CFG->wwwroot . '/local/digitalta/pages/cases/manage.php',
];

$template_context = FilterUtils::apply_filters($template_context);

echo $OUTPUT->render_from_template('local_digitalta/cases/dashboard/dashboard', $template_context);

echo $OUTPUT->footer();
