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
 * Tutors dashboard page
 *
 * @package   local_digitalta
 * @copyright 2024 ADSDR-FUNIBER Scepter Team
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__ . '/../../../../config.php');
require_once($CFG->dirroot . '/local/digitalta/classes/tutors.php');

require_login();

use local_digitalta\Tutors;

$pagetitle = get_string('tutors:title', 'local_digitalta');

$PAGE->set_url(new moodle_url('/local/digitalta/pages/tutors/index.php'));
$PAGE->set_context(context_system::instance());
$PAGE->set_title($pagetitle);
$PAGE->requires->js_call_amd('local_digitalta/tutors/main', 'init');

echo $OUTPUT->header();

$tutors = Tutors::get_all_tutors();
$formattedTutors = [];

foreach ($tutors as $tutor) {
    $newTutor = new stdClass();
    $newTutor->name = $tutor->firstname . " " . $tutor->lastname;
    $newTutor->position = "Tutor";
    if ($tutor->institution) {
        $newTutor->position .= " at " . $tutor->institution;
    }
    // TODO: Role + Institution

    $tutor_picture = new user_picture($tutor);
    $tutor_picture->size = 101;
    $newTutor->imageurl = $tutor_picture->get_url($PAGE)->__toString();

    $newTutor->profileurl = $CFG->wwwroot . "/local/digitalta/pages/profile/index.php?id=" . $tutor->id;

    $newTutor->tags = [];
    $newTutor->themes = [];

    $formattedTutors['data'][] = ['user' => $newTutor];
}

$templatecontext = [
    "component" => "user",
    "title" => $pagetitle,
    "tutors"=> $formattedTutors,
];

// $templatecontext = filter_utils::apply_filters($templatecontext);

echo $OUTPUT->render_from_template('local_digitalta/tutors/dashboard/dashboard', $templatecontext);

echo $OUTPUT->footer();
