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
 * Experience class
 *
 * @package   local_digitalta
 * @copyright 2024 ADSDR-FUNIBER Scepter Team
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_digitalta;

require_once($CFG->dirroot . '/local/digitalta/classes/component.php');

/**
 * This class is used to represent the experience entity
 *
 * @copyright 2024 ADSDR-FUNIBER Scepter Team
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class Experience
{
    use Component;

    /** @var int The identifier of the experience. */
    public $id;

    /** @var int The identifier of the user who created the experience. */
    public $userid;

    /** @var object The object of the user who created the experience. */
    public $user;

    /** @var string The title of the experience. */
    public $title;

    /** @var string The language of the experience. */
    public $lang;

    /** @var int The video of the experience. */
    public $visible;

    /** @var int The status of the experience. */
    public $status;

    /** @var int The date the experience was created. */
    public $timecreated;

    /** @var string The date the experience was created in string format. */
    public $timecreated_string;

    /** @var int The date the experience was modified. */
    public $timemodified;

    /** @var array The sections of the experience. */
    public $sections;

    /** @var string The URL of the picture of the experience. */
    public $pictureurl;

    /**
     * Constructor.
     * 
     * @param $data array The data to populate the experience with.
     */
    public function __construct($experience = null)
    {
        foreach ($experience as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
    }
}
