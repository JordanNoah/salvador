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
 * Experience view page
 *
 * @package   local_digitalta
 * @copyright 2024 ADSDR-FUNIBER Scepter Team
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__ . '/../../../../config.php');
require_once($CFG->dirroot . '/local/digitalta/classes/chat.php');
require_once($CFG->dirroot . '/local/digitalta/classes/experiences.php');
require_once($CFG->dirroot . '/local/digitalta/classes/resources.php');
require_once($CFG->dirroot . '/local/digitalta/classes/sections.php');
require_once($CFG->dirroot . '/local/digitalta/classes/tinyeditorhandler.php');
require_once($CFG->dirroot . '/local/digitalta/classes/tutors.php');
require_once($CFG->dirroot . '/local/digitalta/classes/googlemeet/client.php');
require_once($CFG->dirroot . '/local/digitalta/classes/utils/filterutils.php');
require_once($CFG->dirroot . '/local/digitalta/locallib.php');

use local_digitalta\Chat;
use local_digitalta\Experiences;
use local_digitalta\GoogleMeetClient;
use local_digitalta\GoogleMeetHelper;
use local_digitalta\Tutors;
use local_digitalta\Resources;
use local_digitalta\Sections;
use local_digitalta\TinyEditorHandler;
use local_digitalta\utils\FilterUtils;

require_login();

$id = required_param('id', PARAM_INT);

function get_googlemeet_call_button($chatid)
{
    $client = new GoogleMeetClient($chatid);
    if (!$client->enabled) {
        return;
    }
    if ($client->check_login()) {
        $client->logout();
    }
    $meetingrecord = GoogleMeetHelper::get_googlemeet_record(1);
    if ($meetingrecord) {
        return '<button class="btn btn-zoom-call btn-sm mt-2  mr-2" onclick="window.open(\'https://meet.google.com/' . $meetingrecord->meetingcode . '\', \'_blank\');"> <i class="fa fa-video-camera"></i> ' . get_string('tutoring:joinvideocall', 'local_digitalta') . '</button>';
    } else {
        return $client->print_login_popup($chatid);
    }
}

// Seting the page url and context
$PAGE->set_url(new moodle_url('/local/digitalta/pages/experiences/view.php', ['id' => $id]));
$PAGE->set_context(context_system::instance());
$PAGE->requires->js_call_amd('local_digitalta/reactions/main', 'init');
$PAGE->requires->js_call_amd('local_digitalta/experiences/main', 'init');
$PAGE->requires->js_call_amd('local_digitalta/tutoring/google-meet', 'init');

// Get the experience
if (!$experience = Experiences::get_experience($id)) {
    throw new moodle_exception('invalidexperience', 'local_digitalta');
}
$experience->sections = array_map(function ($section) {
    $groupname = Sections::get_group($section->groupid)->name;
    list($section->groupname, $section->groupname_simplified) =
        local_digitalta_get_element_translation('section_group', $groupname);
    $section->active = false;
    return $section;
}, $experience->sections);
FilterUtils::apply_filters($experience->sections);
$experience->sections[0]->active = true;

// Set the page title
$PAGE->set_title($experience->title);

// Get the user and the user picture
$user = get_complete_user_data('id', $experience->userid);
$user_picture = new user_picture($user);
$user_picture->size = 101;

// Get the resources
$resources = [];
if ($resource_assignments = Resources::get_assignments_for_component('experience', $experience->id)) {
    $resources = array_map(function ($resource_assignment) {
        if (!$resource = Resources::get_resource($resource_assignment->resourceid)) {
            return null;
        }
        $resource->type = Resources::get_type($resource->type)->name;
        $resource->comment = $resource_assignment->description;
        return $resource;
    }, $resource_assignments);
}
$resources = array_filter($resources);

// Get the tutors
$tutors = Tutors::requests_get_by_experience($experience->id);
$tutors = array_map(function ($tutor) use ($DB, $PAGE) {
    $tutor_info = $DB->get_record('user', ['id' => $tutor->tutorid]);
    $tutor_picture = new user_picture($tutor_info);
    $tutor_picture->size = 101;
    return [
        'id' => $tutor_info->id,
        'firstname' => $tutor_info->firstname,
        'lastname' => $tutor_info->lastname,
        'profileimageurl' => $tutor_picture->get_url($PAGE)->__toString()
    ];
}, $tutors);

echo $OUTPUT->header();

(new TinyEditorHandler)->get_config_editor(['maxfiles' => 1]);

$template_context = [
    'component' => 'experience',
    'experience' => [
        'data' => $experience,
        'pictureurl' => Experiences::get_picture_url($experience),
        'deleteurl' => $CFG->wwwroot . '/local/digitalta/pages/experiences/delete.php?id=',
        'exporturl' => $CFG->wwwroot . '/local/digitalta/pages/cases/manage.php?experienceid=',
    ],
    'user' => [
        'id' => $user->id,
        'name' => $user->firstname . " " . $user->lastname,
        'email' => $user->email,
        'imageurl' => $user_picture->get_url($PAGE)->__toString(),
        'profileurl' => $CFG->wwwroot . '/local/digitalta/pages/profile/index.php?id=' . $user->id,
    ],
    'resources' => $resources,
    'canedit' => Experiences::check_permissions($experience, $USER),
    'tutorrepourl' => $CFG->wwwroot . '/local/digitalta/pages/tutors/index.php?id=' . $experience->id,
    'tutorslist' => $tutors,
    'viewtagurl' => $CFG->wwwroot . '/local/digitalta/pages/tags/view.php?type=tag&id=',
    'viewthemeurl' => $CFG->wwwroot . '/local/digitalta/pages/tags/view.php?type=theme&id='
];
//$template_context = FilterUtils::apply_filters($template_context);

$experience_chat = Chat::get_chat_room_by_experience($id);
if ($experience_chat) {
    $experience_chatid = $experience_chat->id;
    $template_context['googlemeetcall']['button'] = get_googlemeet_call_button($experience_chatid);
    $meeting_record = GoogleMeetHelper::get_googlemeet_record($experience_chatid);
    $template_context['googlemeetcall']['closecall']  = $meeting_record ? $meeting_record->chatid : null;
}

echo $OUTPUT->render_from_template('local_digitalta/experiences/view/view', $template_context);

echo $OUTPUT->footer();
