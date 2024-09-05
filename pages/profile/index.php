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
 * Profile page
 *
 * @package   local_digitalta
 * @copyright 2024 ADSDR-FUNIBER Scepter Team
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__ . '/../../../../config.php');
require_once($CFG->dirroot . '/local/digitalta/classes/cases.php');
require_once($CFG->dirroot . '/local/digitalta/classes/experiences.php');
require_once($CFG->dirroot . '/local/digitalta/classes/utils/filterutils.php');

$id = required_param('id', PARAM_INT);

require_login();

use local_digitalta\Cases;
use local_digitalta\Experiences;
use local_digitalta\utils\FilterUtils;

$pagetitle = get_string('profile:title', 'local_digitalta');

$PAGE->set_url(new moodle_url('/local/digitalta/pages/profile/index.php', ['id' => $id]));
$PAGE->set_context(context_system::instance()) ;
$PAGE->set_title($pagetitle);
$PAGE->requires->js_call_amd('local_digitalta/reactions/main', 'init');

echo $OUTPUT->header();

// Get the user data
$user = get_complete_user_data("id", $id);
$picture = new user_picture($user);
$picture->size = 101;

// Get the user experiences
$experiences = Experiences::get_experiences(['userid' => $user->id]);
$experiences = array_map(function ($experience) {
    return $experience;
}, $experiences);
array_multisort(
    array_column($experiences, 'timecreated'), SORT_DESC,
    $experiences);

// Get the user cases
$cases = Cases::get_cases(['userid' => $user->id]);
array_multisort(
    array_column($cases, 'timecreated'), SORT_DESC,
    $cases);

$templatecontext = [
    'user' => [
        'id' => $user->id,
        'name' => $user->firstname . ' ' . $user->lastname,
        'email' => $user->email,
        'imageurl' => $picture->get_url($PAGE)->__toString(),
        'editurl' => $CFG->wwwroot . '/user/editadvanced.php?id=' . $user->id,
    ],
    'experiences' => [
        'component' => 'experience',
        'data' => $experiences,
        'showimageprofile' => false,
        'showcontrols' => true,
        'showcontrolsadmin' => is_siteadmin($USER),
        'viewurl' => $CFG->wwwroot . '/local/digitalta/pages/experiences/view.php?id=',
    ], 
    'cases' => [
        'component' => 'case',
        'data' => $cases,
        'showimageprofile' => false,
        'showcontrols' => true,
        'showcontrolsadmin' => is_siteadmin($USER),
        'viewurl' => $CFG->wwwroot . '/local/digitalta/pages/cases/view.php?id=',
    ],
    'viewtagurl' => $CFG->wwwroot . '/local/digitalta/pages/tags/view.php?type=tag&id=',
    'viewthemeurl' => $CFG->wwwroot . '/local/digitalta/pages/tags/view.php?type=theme&id='
];

$templatecontext = FilterUtils::apply_filters($templatecontext);

echo $OUTPUT->render_from_template('local_digitalta/profile/profile', $templatecontext);

echo $OUTPUT->footer();
