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
 * Library of functions and constants for the local_digitalta plugin.
 *
 * @package   local_digitalta
 * @copyright ADSDR-FUNIBER Scepter Team
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

const LOCAL_DIGITALTA_COMPONENTS = [
    "experience",
    "case",
    "resource",
    "user"
];

const LOCAL_DIGITALTA_MODIFIERS = [
    "theme",
    "tag"
];

const LOCAL_DIGITALTA_THEMES = [
    "Digital Technology",
    "Classroom Management",
    "Communication and Relationship Building",
    "Diversity and Inclusion",
    "Professional Collaboration and Development",
    "School Culture",
    "Curriculum Planning and Development",
    "Others"
];

const LOCAL_DIGITALTA_RESOURCE_TYPES = [
    "Other",
    "Book",
    "Chart",
    "Comic",
    "Diary",
    "Field Notes",
    "Image",
    "Interview",
    "Journal",
    "Magazine",
    "Map",
    "Music",
    "Newspaper",
    "Photograph",
    "Podcast",
    "Report",
    "Study Case",
    "Video",
    "Website",
];

const LOCAL_DIGITALTA_RESOURCE_FORMATS = [
    "None",
    "Link",
    "Image",
    "Video",
    "Document"
];

const LOCAL_DIGITALTA_SECTION_GROUPS = [
    "General",
    "What?",
    "So What?",
    "Now What?"
];

const LOCAL_DIGITALTA_SECTION_TYPES = [
    "text"
];

/**
 * Get the translation of an element.
 *
 * @param string $element The type of element to translate.
 * @param string $string The string to translate.
 * @return array The translated string and the simplified string.
 *
 * @todo This function should be moved to a helper class.
 * @todo This function should use the values from the database.
 */
function local_digitalta_get_element_translation(string $element, string $string): array {
    switch ($element) {
        case "component":
            $elements = LOCAL_DIGITALTA_COMPONENTS;
            break;
        case "modifier":
            $elements = LOCAL_DIGITALTA_MODIFIERS;
            break;
        case "theme":
            $elements = LOCAL_DIGITALTA_THEMES;
            break;
        case "resource_type":
            $elements = LOCAL_DIGITALTA_RESOURCE_TYPES;
            break;
        case "resource_format":
            $elements = LOCAL_DIGITALTA_RESOURCE_FORMATS;
            break;
        case "section_group":
            $elements = LOCAL_DIGITALTA_SECTION_GROUPS;
            break;
        case "section_type":
            $elements = LOCAL_DIGITALTA_SECTION_TYPES;
            break;
        default:
            return $string;
    }
    if (!in_array($string, $elements)
            and !array_key_exists($string, $elements)) {
        return $string;
    }
    $string = local_digitalta_get_simplified_string($string);
    return [
        get_string($element . ":" . $string, 'local_digitalta'),
        $string
    ];
}

/**
 * Get the simplified version of a translation string.
 *
 * @param string $string The string to translate.
 * @return string The simplified string.
 *
 * @todo This function should be moved to a helper class.
 * @todo This function should use the values from the database.
 */
function local_digitalta_get_simplified_string(string $string) {
    return strtolower(str_replace("?", "", str_replace(" ", "_", $string)));
}
