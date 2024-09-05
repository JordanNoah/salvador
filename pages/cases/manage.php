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
 * Case manage page
 *
 * @package   local_digitalta
 * @copyright 2024 ADSDR-FUNIBER Scepter Team
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__ . '/../../../../config.php');
require_once($CFG->dirroot . '/local/digitalta/classes/cases.php');
require_once($CFG->dirroot . '/local/digitalta/classes/components.php');
require_once($CFG->dirroot . '/local/digitalta/classes/experiences.php');
require_once($CFG->dirroot . '/local/digitalta/classes/languages.php');
require_once($CFG->dirroot . '/local/digitalta/classes/sections.php');
require_once($CFG->dirroot . '/local/digitalta/classes/tinyeditorhandler.php');

use local_digitalta\Cases;
use local_digitalta\Components;
use local_digitalta\Experiences;
use local_digitalta\Languages;
use local_digitalta\Sections;
use local_digitalta\TinyEditorHandler;

require_login();

$caseid       = optional_param('id', 0, PARAM_INT);
$experienceid = optional_param('experienceid', 0, PARAM_INT);
$casetitle    = optional_param('casetitle', null, PARAM_RAW);

$pagetitle = get_string('cases:manage:add', 'local_digitalta');

$PAGE->set_url(new moodle_url('/local/digitalta/pages/cases/manage.php', [
    'id' => $caseid,
    'experienceid' => $experienceid,
    'casetitle' => $casetitle
]));
$PAGE->set_context(context_system::instance());
$PAGE->requires->js_call_amd(
    'local_digitalta/cases/main',
    'init',
    [
        'url_view' => $CFG->wwwroot . '/local/digitalta/pages/cases/view.php?id=', 
    ]
);
if ($caseid > 0) {
    if (!$case = Cases::get_case($caseid)) {
        throw new Exception('Invalid case');
    }
    $pagetitle = $case->title;
} elseif ($experienceid > 0) {
    if (!$experience = Experiences::get_experience($experienceid)) {
        throw new Exception('Invalid experience');
    }
    $record               = new stdClass();
    $record->experienceid = $experienceid;
    $record->title        = $experience->title;
    $record->description  = "";
    $record->lang         = $experience->lang;
    $record->id           = Cases::add_case($record);
    $case                 = Cases::get_case($record->id);
} elseif ($casetitle != null) {
    $record               = new stdClass();
    $record->title        = $casetitle;
    $record->description  = "";
    $record->lang         = "";
    $record->id           = Cases::add_case($record);
    $case                 = Cases::get_case($record->id);
} else {
    throw new Exception('Invalid parameters');
}

$PAGE->set_title($pagetitle);

$sections = Sections::get_sections([
    'component' => Components::get_component_by_name('case')->id,
    'componentinstance' => $case->id
]);

$languages = Languages::get_all_languages(true);
$languages = array_map(function ($language) use ($case) {
    $language->selected = $language->code === $case->lang;
    return (object) [
        'key' => $language->code,
        'value' => $language->name,
        'selected' => $language->selected
    ];
}, $languages);

echo $OUTPUT->header();

(new TinyEditorHandler)->get_config_editor(['maxfiles' => 1]);

$template_context = [
    'component' => 'case',
    'title' => $pagetitle,
    'case' => $case,
    'sections' => $sections,
    'languages' => $languages,
    'experience' => $experience ?? null,
];

echo $OUTPUT->render_from_template('local_digitalta/cases/manage/manage', $template_context);

echo $OUTPUT->footer();
