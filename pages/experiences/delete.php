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
 * Experience delete page
 *
 * @package   local_digitalta
 * @copyright 2024 ADSDR-FUNIBER Scepter Team
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__ . '/../../../../config.php');
require_once($CFG->dirroot . '/local/digitalta/lib.php');
require_once($CFG->dirroot . '/local/digitalta/classes/experiences.php');

use local_digitalta\Experiences;

require_login();

$pagetitle = get_string('experience:delete', 'local_digitalta');

$id = required_param('id', PARAM_INT);
$delete = optional_param('delete', '', PARAM_ALPHANUM);

$PAGE->set_url(new moodle_url('/local/digitalta/pages/experiences/delete.php', ['id' => $id]));
$PAGE->set_context(context_system::instance());
$PAGE->set_title($pagetitle);

if (!$experience = Experiences::get_experience($id)) {
    throw new moodle_exception('invalidexperience', 'local_digitalta');
}

if (!Experiences::check_permissions($experience, $USER)) {
    throw new moodle_exception('errorpermissions', 'local_digitalta');
}

if ($delete === md5($experience->timecreated)) {
    if (!Experiences::delete_experience($experience)) {
        throw new moodle_exception('errordeleteexperience', 'local_digitalta');
    }
    redirect(new moodle_url('/local/digitalta/pages/experiences/index.php'),
        get_string('experience:delete:success', 'local_digitalta'));
    exit;
}

$continueurl = new moodle_url('/local/digitalta/pages/experiences/delete.php',
    ['id' => $experience->id, 'delete' => md5($experience->timecreated)]);
$backurl = new moodle_url('/local/digitalta/pages/experiences/view.php', ['id' => $experience->id]);
$continuebutton = new single_button(
    $continueurl,
    get_string('delete'),
    'post',
    false,
    ['data-action' => 'delete']
);

echo $OUTPUT->header();
echo $OUTPUT->confirm(
    "<p>"
    . get_string('experience:delete:confirm', 'local_digitalta')
    . "</p><p style=\"font-weight: bold; \">"
    . $experience->title
    . "</p>",
    $continuebutton, $backurl);
echo $OUTPUT->footer();
