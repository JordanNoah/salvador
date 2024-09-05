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
 * StudyCase class
 *
 * @package   local_digitalta
 * @copyright 2024 ADSDR-FUNIBER Scepter Team
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_digitalta;

require_once($CFG->dirroot . '/local/digitalta/classes/component.php');

/**
 * This class is used to represent the case entity.
 *
 * @copyright 2024 ADSDR-FUNIBER Scepter Team
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class StudyCase
{
    use Component;

    /** @var int The identifier of the case. */
    public $id;

    /** @var int The identifier of the experience which the case was created from. */
    public $experienceid;

    /** @var string The identifier of the resource associated with the case. */
    public $resourceid;

    /** @var int The identifier of the user who created the case. */
    public $userid;

    /** @var string The title of the case. */
    public $title;

    /** @var string The description of the case. */
    public $description;

    /** @var string The language of the case. */
    public $lang;

    /** @var int The status of the case. */
    public $status;

    /** @var int The date the case was created. */
    public $timecreated;

    /** @var string The date the case was created in string format. */
    public $timecreated_string;

    /** @var int The date the case was modified. */
    public $timemodified;

    /** @var array The sections of the experience. */
    public $sections;

    /**
     * Constructor.
     * 
     * @param $case mixed The case to construct.
     */
    public function __construct($case = [])
    {
        foreach ($case as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
    }
}
