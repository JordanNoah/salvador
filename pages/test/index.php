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
 * Test
 *
 * @package   local_digitalta
 * @copyright 2024 ADSDR-FUNIBER Scepter Team
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once (__DIR__ . '/../../../../config.php');

require_login();


// Setea el título de la página
$PAGE->set_url(new moodle_url('/local/digitalta/pages/test/index.php'));
$PAGE->set_context(context_system::instance());

echo $OUTPUT->header();


$user_list = [
  [
    'profile_img' => 'https://www.w3schools.com/howto/img_avatar.png',
    'name' => 'Elias',
    'university' => 'UNEATLANTICO',
  ],
  [
    'profile_img' => 'https://www.w3schools.com/howto/img_avatar2.png',
    'name' => 'Maria',
    'university' => 'FUNIBER',
  ],
];


echo $OUTPUT->render_from_template('local_digitalta/test/index', $user_list);

echo $OUTPUT->footer();
