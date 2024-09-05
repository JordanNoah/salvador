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
 * Case view page
 *
 * @package   local_digitalta
 * @copyright 2024 ADSDR-FUNIBER Scepter Team
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__ . '/../../../../config.php');
require_once($CFG->dirroot . '/local/digitalta/classes/cases.php');
require_once($CFG->dirroot . '/local/digitalta/classes/sections.php');
require_once($CFG->dirroot . '/local/digitalta/classes/utils/filterutils.php');

use local_digitalta\Cases;
use local_digitalta\Sections;
use local_digitalta\utils\FilterUtils;

require_login();

$id = required_param('id', PARAM_INT);

// Seting the page url and context
$PAGE->set_url(new moodle_url('/local/digitalta/pages/cases/view.php', ['id' => $id]));
$PAGE->set_context(context_system::instance());
$PAGE->requires->js_call_amd('local_digitalta/reactions/main', 'init');

// Get the case
if (!$case = Cases::get_case($id)) {
    throw new moodle_exception('invalidcase', 'local_digitalta');
}
$case->sections = array_map(function ($section) {
    $groupname = Sections::get_group($section->groupid)->name;
    list($section->groupname, $section->groupname_simplified) =
        local_digitalta_get_element_translation('section_group', $groupname);
    return $section;
}, $case->sections);
//FilterUtils::apply_filters($case->sections);

// Set the page title
$PAGE->set_title($case->title);

// Get the user and the user picture
$user = get_complete_user_data('id', $case->userid);
$user_picture = new user_picture($user);
$user_picture->size = 101;

echo $OUTPUT->header();

$templateContext = [
    'component' => 'case',
    'case' => [
        'data' => $case,
        'manageurl' => $CFG->wwwroot . '/local/digitalta/pages/cases/manage.php?id=',
        'deleteurl' => $CFG->wwwroot . '/local/digitalta/pages/cases/delete.php?id=',
    ],
    'user' => [
        'id' => $user->id,
        'name' => $user->firstname . " " . $user->lastname,
        'email' => $user->email,
        'imageurl' => $user_picture->get_url($PAGE)->__toString(),
        'profileurl' => $CFG->wwwroot . '/local/digitalta/pages/profile/index.php?id=' . $user->id,
    ],
    'canedit' => Cases::check_permissions($case, $USER),
    'viewtagurl' => $CFG->wwwroot . '/local/digitalta/pages/tags/view.php?type=tag&id=',
    'viewthemeurl' => $CFG->wwwroot . '/local/digitalta/pages/tags/view.php?type=theme&id='
];
//$templateContext = FilterUtils::apply_filters($templateContext);

echo $OUTPUT->render_from_template('local_digitalta/cases/view/view', $templateContext);

echo $OUTPUT->footer();
