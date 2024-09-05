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
 * Plugin administration pages are defined here.
 *
 * @package     local_digitalta
 * @category    admin
 * @copyright   2024 ADSDR-FUNIBER Scepter Team
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

if ($ADMIN->fulltree) {
  $settings = new admin_settingpage('local_digitalta', 'Local DIGITALTA settings');

  $ADMIN->add('localplugins', $settings);

  $options = [''];
  $issuers = \core\oauth2\api::get_all_issuers();

  foreach ($issuers as $issuer) {
    $options[$issuer->get('id')] = s($issuer->get('name'));
  }

  $settings->add(new admin_setting_configselect(
    'local_digitalta/issuerid',
    get_string('config:issuerid', 'local_digitalta'),
    '',
    0,
    $options
  ));
}
