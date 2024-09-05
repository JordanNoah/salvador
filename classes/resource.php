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
 * Resource class
 *
 * @package   local_digitalta
 * @copyright 2024 ADSDR-FUNIBER Scepter Team
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_digitalta;

require_once($CFG->dirroot . '/local/digitalta/classes/component.php');

/**
 * This class is used to represent the resource entity.
 *
 * @copyright 2024 ADSDR-FUNIBER Scepter Team
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class Resource
{
    use Component;

    /** @var int The identifier of the resource. */
    public $id;
    
    /** @var string The name of the resource. */
    public $name;
    
    /** @var string The description of the resource. */
    public $description;
    
    /** @var string The type of the resource. */
    public $type;

    /** @var string The format of the resource. */
    public $format;
    
    /** @var string The path of the resource. */
    public $path;

    /** @var string The language of the resource. */
    public $lang;

    /** @var int The identifier of the user who created the resource. */
    public $userid;
    
    /** @var int The timestamp of when the resource was created. */
    public $timecreated;
    
    /** @var int The timestamp of when the resource was last modified. */
    public $timemodified;

    /** @var string The reason why the resource was assigned to a component. */
    public $comment;

    /**
     * Constructor.
     * 
     * @param $resource mixed The resource to construct.
     */
    public function __construct($resource = [])
    {
        foreach ($resource as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = ($key === 'description' && is_array($value))
                    ? $value['text']
                    : $value;
            }
        }
    }
}
