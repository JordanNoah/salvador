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
 * External functions and service definitions.
 *
 * @package    local_digitalta
 * @copyright  2024 ADSDR-FUNIBER Scepter Team
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$functions = [

    // Cases
    'local_digitalta_cases_edit' => [
        'classname'   => 'external_cases_edit',
        'methodname'  => 'cases_edit',
        'classpath'   => 'local/digitalta/classes/webservices/cases/external_cases_edit.php',
        'description' => 'Edit a Case',
        'type'        => 'write',
        'requirelogin' => true,
        'ajax'        => true,
    ],
    'local_digitalta_cases_get' => [
        'classname'   => 'external_cases_get',
        'methodname'  => 'cases_get',
        'classpath'   => 'local/digitalta/classes/webservices/cases/external_cases_get.php',
        'description' => 'Get all cases',
        'type'        => 'read',
        'requirelogin' => true,
        'ajax'        => true,
    ],
    'local_digitalta_cases_get_paginated' => [
        'classname'   => 'external_cases_get_by_pagination',
        'methodname'  => 'cases_get_by_pagination',
        'classpath'   => 'local/digitalta/classes/webservices/cases/external_cases_get_by_pagination.php',
        'description' => 'Get cases by pagination',
        'type'        => 'read',
        'requirelogin' => true,
        'ajax'        => true,
    ],
    'local_digitalta_cases_get_langs' => [
        'classname'  => 'external_cases_get_used_langs',
        'methodname' => 'cases_get_used_langs',
        'classpath'  => 'local/digitalta/classes/webservices/cases/external_cases_get_used_langs.php',
        'description' => 'Get all languages used in cases',
        'type'        => 'read',
        'requirelogin' => true,
        'ajax'        => true
    ],
    // Context
    'local_digitalta_context_upsert' => [
        'classname'   => 'external_context_upsert',
        'methodname'  => 'context_upsert',
        'classpath'   => 'local/digitalta/classes/webservices/context/external_context_upsert.php',
        'description' => 'upsert a context',
        'type'        => 'write',
        'requirelogin' => true,
        'ajax'        => true,
    ],
    'local_digitalta_context_delete' => [
        'classname'   => 'external_context_delete',
        'methodname'  => 'context_delete',
        'classpath'   => 'local/digitalta/classes/webservices/context/external_context_delete.php',
        'description' => 'upsert a context',
        'type'        => 'write',
        'requirelogin' => true,
        'ajax'        => true,
    ],

    // Experiences
    'local_digitalta_experiences_get_by_pagination' => [
        'classname'   => 'external_experiences_get_by_pagination',
        'methodname'  => 'experiences_get_by_pagination',
        'classpath'   => 'local/digitalta/classes/webservices/experiences/external_experiences_get_by_pagination.php',
        'description' => '',
        'type'        => 'read',
        'requirelogin' => true,
        'ajax'        => true,
    ],
    'local_digitalta_experiences_get' => [
        'classname'   => 'external_experiences_get',
        'methodname'  => 'experiences_get',
        'classpath'   => 'local/digitalta/classes/webservices/experiences/external_experiences_get.php',
        'description' => 'Get all experiences',
        'type'        => 'read',
        'requirelogin' => true,
        'ajax'        => true,
    ],
    'local_digitalta_experiences_upsert' => [
        'classname'   => 'external_experiences_upsert',
        'methodname'  => 'experiences_upsert',
        'classpath'   => 'local/digitalta/classes/webservices/experiences/external_experiences_upsert.php',
        'description' => 'upsert an experience',
        'type'        => 'write',
        'requirelogin' => true,
        'ajax'        => true,
    ],
    'local_digitalta_experiences_toggle_status' => [
        'classname'   => 'external_experiences_toggle_status',
        'methodname'  => 'experiences_toggle_status',
        'classpath'   => 'local/digitalta/classes/webservices/experiences/external_experiences_toggle_status.php',
        'description' => 'Toggle the status of an experience',
        'type'        => 'write',
        'requirelogin' => true,
        'ajax'        => true,
    ],
    'local_digitalta_experiences_get_used_langs' => [
        'classname' => 'external_experiences_get_used_langs',
        'methodname'  => 'experiences_get_used_langs',
        'classpath'   => 'local/digitalta/classes/webservices/experiences/external_experiences_get_used_langs.php',
        'description' => 'Get all languages used in experiences',
        'type'        => 'read',
        'requirelogin' => true,
        'ajax'        => true
    ],
    // Files
    'local_digitalta_files_prepare_draft_area_html' => [
        'classname'   => 'external_files_prepare_draft_area_html',
        'methodname'  => 'prepare_draft_area_html',
        'classpath'   => 'local/digitalta/classes/webservices/files/external_files_prepare_draft_area_html.php',
        'description' => 'Prepare draft area html',
        'type'        => 'read',
        'requirelogin' => true,
        'ajax'        => true,
    ],
    'local_digitalta_files_upload_from_draft' => [
        'classname'   => 'external_files_upload_from_draft',
        'methodname'  => 'upload_file_from_draft',
        'classpath'   => 'local/digitalta/classes/webservices/files/external_files_upload_from_draft.php',
        'description' => 'Upload a file',
        'type'        => 'write',
        'requirelogin' => true,
        'ajax'        => true,
    ],

    // Languages
    'local_digitalta_languages_get' => [
        'classname'   => 'external_languages_get',
        'methodname'  => 'languages_get',
        'classpath'   => 'local/digitalta/classes/webservices/languages/external_languages_get.php',
        'description' => 'Get all languages',
        'type'        => 'read',
        'requirelogin' => true,
        'ajax'        => true,
    ],

    // Reactions
    'local_digitalta_reactions_get_comments' => [
        'classname'   => 'external_reactions_get_comments',
        'methodname'  => 'reactions_get_comments',
        'classpath'   => 'local/digitalta/classes/webservices/reactions/external_reactions_get_comments.php',
        'description' => 'Get comments for an instance of a component',
        'type'        => 'write',
        'requirelogin' => true,
        'ajax'        => true,
    ],
    'local_digitalta_reactions_add_comment' => [
        'classname'   => 'external_reactions_add_comment',
        'methodname'  => 'reactions_add_comment',
        'classpath'   => 'local/digitalta/classes/webservices/reactions/external_reactions_add_comment.php',
        'description' => 'Add a comment for an instance of a component',
        'type'        => 'write',
        'requirelogin' => true,
        'ajax'        => true,
    ],
    'local_digitalta_reactions_toggle_like_dislike' => [
        'classname'   => 'external_reactions_toggle_like_dislike',
        'methodname'  => 'reactions_toggle_like_dislike',
        'classpath'   => 'local/digitalta/classes/webservices/reactions/external_reactions_toggle_like_dislike.php',
        'description' => 'Toggle like or dislike for an instance of a a component',
        'type'        => 'write',
        'requirelogin' => true,
        'ajax'        => true,
    ],
    'local_digitalta_reactions_toggle_report' => [
        'classname'   => 'external_reactions_toggle_report',
        'methodname'  => 'reactions_toggle_report',
        'classpath'   => 'local/digitalta/classes/webservices/reactions/external_reactions_toggle_report.php',
        'description' => 'toggle a report for an experience or a case',
        'type'        => 'write',
        'requirelogin' => true,
        'ajax'        => true,
    ],

    // Resources
    'local_digitalta_resources_upsert' => [
        'classname'   => 'external_resources_upsert',
        'methodname'  => 'resources_upsert',
        'classpath'   => 'local/digitalta/classes/webservices/resources/external_resources_upsert.php',
        'description' => 'upsert a resource',
        'type'        => 'write',
        'requirelogin' => true,
        'ajax'        => true,
    ],
    'local_digitalta_resources_get' => [
        'classname'   => 'external_resources_get',
        'methodname'  => 'resources_get',
        'classpath'   => 'local/digitalta/classes/webservices/resources/external_resources_get.php',
        'description' => 'get resources',
        'type'        => 'read',
        'requirelogin' => true,
        'ajax'        => true,
    ],
    'local_digitalta_resources_get_by_pagination' => [
        'classname'   => 'external_resources_get_by_pagination',
        'methodname'  => 'resources_get_by_pagination',
        'classpath'   => 'local/digitalta/classes/webservices/resources/external_resources_get_by_pagination.php',
        'description' => 'get resources',
        'type'        => 'read',
        'requirelogin' => true,
        'ajax'        => true,
    ],
    'local_digitalta_resources_types_get' => [
        'classname'   => 'external_resources_types_get',
        'methodname'  => 'resources_types_get',
        'classpath'   => 'local/digitalta/classes/webservices/resources/external_resources_types_get.php',
        'description' => 'get resource types',
        'type'        => 'read',
        'requirelogin' => true,
        'ajax'        => true,
    ],
    'local_digitalta_resources_assign' => [
        'classname'   => 'external_resources_assign',
        'methodname'  => 'resources_assign',
        'classpath'   => 'local/digitalta/classes/webservices/resources/external_resources_assign.php',
        'description' => 'Assign a resource',
        'type'        => 'write',
        'requirelogin' => true,
        'ajax'        => true,
    ],
    'local_digitalta_resources_unassign' => [
        'classname'   => 'external_resources_unassign',
        'methodname'  => 'resources_unassign',
        'classpath'   => 'local/digitalta/classes/webservices/resources/external_resources_unassign.php',
        'description' => 'Unassign a resource',
        'type'        => 'write',
        'requirelogin' => true,
        'ajax'        => true,
    ],
    'local_digitalta_resources_get_assignments_for_component' => [
        'classname'   => 'external_resources_get_assignments_for_component',
        'methodname'  => 'resources_get_assignments_for_component',
        'classpath'   => 'local/digitalta/classes/webservices/resources/external_resources_get_assignments_for_component.php',
        'description' => 'Get resources assigned to a component',
        'type'        => 'read',
        'requirelogin' => true,
        'ajax'        => true,
    ],
    'local_digitalta_resources_get_used_langs' => [
        'classname' => 'external_resources_get_used_langs',
        'methodname'  => 'resources_get_used_langs',
        'classpath'   => 'local/digitalta/classes/webservices/resources/external_resources_get_used_langs.php',
        'description' => 'Get all languages used in resources',
        'type'        => 'read',
        'requirelogin' => true,
        'ajax'        => true
    ],

    // Sections
    'local_digitalta_sections_upsert' => [
        'classname'    => 'external_sections_upsert',
        'methodname'   => 'sections_upsert',
        'classpath'    => 'local/digitalta/classes/webservices/sections/external_sections_upsert.php',
        'description'  => 'upsert a section',
        'type'         => 'write',
        'requirelogin' => true,
        'ajax'         => true,
    ],
    'local_digitalta_sections_delete' => [
        'classname'    => 'external_sections_delete',
        'methodname'   => 'sections_delete',
        'classpath'    => 'local/digitalta/classes/webservices/sections/external_sections_delete.php',
        'description'  => 'delete a section',
        'type'         => 'write',
        'requirelogin' => true,
        'ajax'         => true,
    ],

    // Tags
    'local_digitalta_tags_get' => [
        'classname'   => 'external_tags_get',
        'methodname'  => 'tags_get',
        'classpath'   => 'local/digitalta/classes/webservices/tags/external_tags_get.php',
        'description' => 'Get all tags by text',
        'type'        => 'read',
        'requirelogin' => true,
        'ajax'        => true,
    ],
    'local_digitalta_tags_create' => [
        'classname'   => 'external_tags_create',
        'methodname'  => 'create_tags',
        'classpath'   => 'local/digitalta/classes/webservices/tags/external_tags_create.php',
        'description' => 'Create tags',
        'type'        => 'write',
        'requirelogin' => true,
        'ajax'        => true,
    ],

    // Themes
    'local_digitalta_themes_get' => [
        'classname'   => 'external_themes_get',
        'methodname'  => 'themes_get',
        'classpath'   => 'local/digitalta/classes/webservices/themes/external_themes_get.php',
        'description' => 'Get all themes by text',
        'type'        => 'read',
        'requirelogin' => true,
        'ajax'        => true,
    ],

    // Tutoring
    'local_digitalta_tutoring_tutors_get' => [
        'classname'   => 'external_tutoring_tutors_get',
        'methodname'  => 'tutors_get',
        'classpath'   => 'local/digitalta/classes/webservices/tutoring/external_tutoring_tutors_get.php',
        'description' => 'Get tutors',
        'type'        => 'read',
        'requirelogin' => true,
        'ajax'        => true,
    ],
    'local_digitalta_tutoring_requests_get' => [
        'classname'   => 'external_tutoring_requests_get',
        'methodname'  => 'requests_get',
        'classpath'   => 'local/digitalta/classes/webservices/tutoring/external_tutoring_requests_get.php',
        'description' => 'Get tutor requests',
        'type'        => 'read',
        'requirelogin' => true,
        'ajax'        => true,
    ],
    'local_digitalta_tutoring_requests_add' => [
        'classname'   => 'external_tutoring_requests_add',
        'methodname'  => 'requests_add',
        'classpath'   => 'local/digitalta/classes/webservices/tutoring/external_tutoring_requests_add.php',
        'description' => 'Add tutor request',
        'type'        => 'write',
        'requirelogin' => true,
        'ajax'        => true,
    ],
    'local_digitalta_tutoring_requests_remove' => [
        'classname'   => 'external_tutoring_requests_remove',
        'methodname'  => 'requests_remove',
        'classpath'   => 'local/digitalta/classes/webservices/tutoring/external_tutoring_requests_remove.php',
        'description' => 'add tutor request',
        'type'        => 'write',
        'requirelogin' => true,
        'ajax'        => true,
    ],
    'local_digitalta_tutoring_requests_accept' => [
        'classname'   => 'external_tutoring_requests_accept',
        'methodname'  => 'requests_accept',
        'classpath'   => 'local/digitalta/classes/webservices/tutoring/external_tutoring_requests_accept.php',
        'description' => 'accept tutor request',
        'type'        => 'write',
        'requirelogin' => true,
        'ajax'        => true,
    ],
    'local_digitalta_tutoring_availabilities_create' => [
        'classname'   => 'external_tutoring_availabilities_create',
        'methodname'  => 'availabilities_create',
        'classpath'   => 'local/digitalta/classes/webservices/tutoring/external_tutoring_availabilities_create.php',
        'description' => 'Create a tutor availability',
        'type'        => 'write',
        'requirelogin' => true,
        'ajax'        => true,
    ],
    'local_digitalta_tutoring_availabilities_update' => [
        'classname'   => 'external_tutoring_availabilities_update',
        'methodname'  => 'availabilities_update',
        'classpath'   => 'local/digitalta/classes/webservices/tutoring/external_tutoring_availabilities_update.php',
        'description' => 'Update a tutor availability',
        'type'        => 'write',
        'requirelogin' => true,
        'ajax'        => true,
    ],
    'local_digitalta_tutoring_availabilities_delete' => [
        'classname'   => 'external_tutoring_availabilities_delete',
        'methodname'  => 'availabilities_delete',
        'classpath'   => 'local/digitalta/classes/webservices/tutoring/external_tutoring_availabilities_delete.php',
        'description' => 'Delete a tutor availability',
        'type'        => 'write',
        'requirelogin' => true,
        'ajax'        => true,
    ],
    'local_digitalta_tutoring_meetings_delete' => [
        'classname'   => 'external_tutoring_meetings_delete',
        'methodname'  => 'meetings_delete',
        'classpath'   => 'local/digitalta/classes/webservices/tutoring/external_tutoring_meetings_delete.php',
        'description' => 'Delete a google meet meeting',
        'type'        => 'write',
        'requirelogin' => true,
        'ajax'        => true,
    ],
];