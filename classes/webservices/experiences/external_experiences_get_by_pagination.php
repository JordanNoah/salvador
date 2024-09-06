<?php

defined('MOODLE_INTERNAL') || die();
require_once($CFG->dirroot . '/local/digitalta/classes/experiences.php');
require_once($CFG->dirroot . '/local/digitalta/classes/sections.php');
require_once($CFG->dirroot . '/config.php');
require_login();

class external_experiences_get_by_pagination extends external_api
{
    public static function experiences_get_by_pagination_parameters() {
        return new external_function_parameters(
            [
                'pagenumber' => new external_value(PARAM_INT, 'page number', VALUE_REQUIRED),
                'filters' => new external_value(PARAM_TEXT, 'filters', VALUE_REQUIRED)
            ]
        );
    }

    public static function experiences_get_by_pagination($pagenumber, $filters) {
        global $DB, $CFG;
        $filtersId = null;
        $filters = json_decode($filters, true);

        $experiences = array();
        if (count($filters) > 0) {
            $tags = [];
            $themes = [];
            for ($i = 0; $i < count($filters); $i++) {
                $filter = $filters[$i];
                if ($filter["type"] == "tag"){
                    $tags[] = '"'.$filter["value"].'"';
                }else{
                    $themes[] = '"'.$filter["value"].'"';
                }
            }

            $themesToSearch = '(' . implode(', ', $themes) . ')';
            $tagsToSearch = '(' . implode(', ', $tags) . ')';

            $themesExperience = $DB->get_records_sql(
                "SELECT * FROM mdl_digitalta_themes where name IN ".$themesToSearch
            );

            $tagsExperiences = $DB->get_records_sql(
                "SELECT * FROM mdl_digitalta_tags where name IN ".$tagsToSearch
            );

            $tagsId = array_keys($tagsExperiences);
            $themesId = array_keys($themesExperience);

            $havingSum = "";

            for ($i = 0; $i < count($themesId); $i++) {
                if (strlen($havingSum) == 0){
                    $havingSum .= "HAVING SUM(CASE WHEN modifier = 1 AND modifierinstance = ".$themesId[$i]." THEN 1 ELSE 0 END) > 0 AND ";
                }else{
                    $havingSum .= "SUM(CASE WHEN modifier = 1 AND modifierinstance = ".$themesId[$i]." THEN 1 ELSE 0 END) > 0 AND ";
                }
            }

            for ($i = 0; $i < count($tagsId); $i++) {
                if (strlen($havingSum) == 0){
                    $havingSum .= "HAVING SUM(CASE WHEN modifier = 2 AND modifierinstance = ".$tagsId[$i]." THEN 1 ELSE 0 END) > 0 AND ";
                }else{
                    $havingSum .= "SUM(CASE WHEN modifier = 2 AND modifierinstance = ".$tagsId[$i]." THEN 1 ELSE 0 END) > 0 AND ";
                }
            }
            $query = preg_replace('/\s+AND\s*$/', '', $havingSum);

            $contextDigitalTa = $DB->get_records_sql(
                'WITH FilteredComponentInstances AS (
                        SELECT componentinstance
                            FROM mdl_digitalta_context
                            GROUP BY componentinstance
                                '.$query.'
                            )
                        SELECT
                            componentinstance,
                            GROUP_CONCAT(modifier) AS modifiers,
                            GROUP_CONCAT(modifierinstance) AS modifierinstances
                            FROM mdl_digitalta_context
                            WHERE componentinstance IN (SELECT componentinstance FROM FilteredComponentInstances)
                        GROUP BY componentinstance;'
            );

            $componentInstanceIds = array_keys($contextDigitalTa);

            $componentsInstanceIdsToSearch = '(' . implode(', ', $componentInstanceIds) . ')';
            $components = array_values($DB->get_records_sql(
                'SELECT * FROM mdl_digitalta_experiences where id IN '.$componentsInstanceIdsToSearch
            ));



            for ($i = 0; $i < count($components); $i++) {
                $experience = $components[$i];
                $cleaned_experience = [
                    "id" => $experience->id,
                    "userid" => $experience->userid,
                    "title" => $experience->title,
                    "lang" => $experience->lang,
                    "visible" => $experience->visible,
                    "status" => $experience->status,
                    "timecreated" => $experience->timecreated,
                    "timemodified" => $experience->timemodified
                ];
                $experience_model = new \local_digitalta\Experience($cleaned_experience);
                $x = \local_digitalta\Experiences::get_extra_fields($experience_model);

                $sections = [];
                foreach ($x->sections as $section) {
                    $groupname = \local_digitalta\Sections::get_group($section->groupid)->name;
                    list($section->groupname, $section->groupname_simplified) =
                        local_digitalta_get_element_translation('section_group', $groupname);
                    $section->content = strip_tags($section->content);
                    $sections[$section->groupname_simplified] = $section;
                }

                $x->sections = $sections;

                $experiences[] = $x;
            }
        }else{
            $components = array_values($DB->get_records_sql(
                'SELECT * FROM mdl_digitalta_experiences'
            ));

            for ($i = 0; $i < count($components); $i++) {
                $experience = $components[$i];
                $cleaned_experience = [
                    "id" => $experience->id,
                    "userid" => $experience->userid,
                    "title" => $experience->title,
                    "lang" => $experience->lang,
                    "visible" => $experience->visible,
                    "status" => $experience->status,
                    "timecreated" => $experience->timecreated,
                    "timemodified" => $experience->timemodified
                ];
                $experience_model = new \local_digitalta\Experience($cleaned_experience);
                $x = \local_digitalta\Experiences::get_extra_fields($experience_model);

                $sections = [];
                foreach ($x->sections as $section) {
                    $groupname = \local_digitalta\Sections::get_group($section->groupid)->name;
                    list($section->groupname, $section->groupname_simplified) =
                        local_digitalta_get_element_translation('section_group', $groupname);
                    $section->content = strip_tags($section->content);
                    $sections[$section->groupname_simplified] = $section;
                }

                $x->sections = $sections;
                $experiences[] = $x;
            }
        }
        return array(
            'data' => $experiences,
            'viewurl' => $CFG->wwwroot . '/local/digitalta/pages/experiences/view.php?id='
        );
    }

    public static function experiences_get_by_pagination_returns() {
        return new external_single_structure([
            'data' => new external_multiple_structure(
                new external_single_structure([
                    "id" => new external_value(PARAM_INT, 'id', VALUE_REQUIRED),
                    "userid" => new external_value(PARAM_INT, 'userid', VALUE_REQUIRED),
                    "user" => new external_single_structure([
                        "id" => new external_value(PARAM_INT, 'user', VALUE_REQUIRED),
                        "name" => new external_value(PARAM_TEXT, 'name', VALUE_REQUIRED),
                        "email" => new external_value(PARAM_TEXT, 'email', VALUE_REQUIRED),
                        "imageurl" => new external_value(PARAM_URL, 'image url', VALUE_REQUIRED),
                        "profileurl" => new external_single_structure([])
                    ]),
                    "title" => new external_value(PARAM_TEXT, 'title', VALUE_REQUIRED),
                    "lang" => new external_value(PARAM_TEXT, 'lang', VALUE_REQUIRED),
                    "visible" => new external_value(PARAM_INT, 'visible', VALUE_REQUIRED),
                    "status" => new external_value(PARAM_INT, 'status', VALUE_REQUIRED),
                    "timecreated" => new external_value(PARAM_TEXT, 'timecreated', VALUE_REQUIRED),
                    "timecreated_string" => new external_value(PARAM_TEXT, 'timecreated_string', VALUE_REQUIRED),
                    "timemodified" => new external_value(PARAM_TEXT, 'timemodified', VALUE_REQUIRED),
                    'sections' => new external_single_structure([
                        'what' => new external_single_structure([
                            'id' => new external_value(PARAM_TEXT, 'ID of the what section', VALUE_REQUIRED),
                            'component' => new external_value(PARAM_TEXT, 'Component of the what section', VALUE_REQUIRED),
                            'componentinstance' => new external_value(PARAM_TEXT, 'Component instance of the what section', VALUE_REQUIRED),
                            'groupid' => new external_value(PARAM_TEXT, 'Group ID of the what section', VALUE_REQUIRED),
                            'sequence' => new external_value(PARAM_TEXT, 'Sequence of the what section', VALUE_REQUIRED),
                            'type' => new external_value(PARAM_TEXT, 'Type of the what section', VALUE_REQUIRED),
                            'content' => new external_value(PARAM_RAW, 'Content of the what section', VALUE_REQUIRED),
                            'groupname' => new external_value(PARAM_TEXT, 'Group name of the what section', VALUE_REQUIRED),
                            'groupname_simplified' => new external_value(PARAM_TEXT, 'Simplified group name of the what section', VALUE_REQUIRED)
                        ]),
                        'so_what' => new external_single_structure([
                            'id' => new external_value(PARAM_TEXT, 'ID of the so_what section', VALUE_REQUIRED),
                            'component' => new external_value(PARAM_TEXT, 'Component of the so_what section', VALUE_REQUIRED),
                            'componentinstance' => new external_value(PARAM_TEXT, 'Component instance of the so_what section', VALUE_REQUIRED),
                            'groupid' => new external_value(PARAM_TEXT, 'Group ID of the so_what section', VALUE_REQUIRED),
                            'sequence' => new external_value(PARAM_TEXT, 'Sequence of the so_what section', VALUE_REQUIRED),
                            'type' => new external_value(PARAM_TEXT, 'Type of the so_what section', VALUE_REQUIRED),
                            'content' => new external_value(PARAM_RAW, 'Content of the so_what section', VALUE_REQUIRED),
                            'groupname' => new external_value(PARAM_TEXT, 'Group name of the so_what section', VALUE_REQUIRED),
                            'groupname_simplified' => new external_value(PARAM_TEXT, 'Simplified group name of the so_what section', VALUE_REQUIRED)
                        ]),
                        'now_what' => new external_single_structure([
                            'id' => new external_value(PARAM_TEXT, 'ID of the now_what section', VALUE_REQUIRED),
                            'component' => new external_value(PARAM_TEXT, 'Component of the now_what section', VALUE_REQUIRED),
                            'componentinstance' => new external_value(PARAM_TEXT, 'Component instance of the now_what section', VALUE_REQUIRED),
                            'groupid' => new external_value(PARAM_TEXT, 'Group ID of the now_what section', VALUE_REQUIRED),
                            'sequence' => new external_value(PARAM_TEXT, 'Sequence of the now_what section', VALUE_REQUIRED),
                            'type' => new external_value(PARAM_TEXT, 'Type of the now_what section', VALUE_REQUIRED),
                            'content' => new external_value(PARAM_RAW, 'Content of the now_what section', VALUE_REQUIRED),
                            'groupname' => new external_value(PARAM_TEXT, 'Group name of the now_what section', VALUE_REQUIRED),
                            'groupname_simplified' => new external_value(PARAM_TEXT, 'Simplified group name of the now_what section', VALUE_REQUIRED)
                        ])
                    ]),
                    "pictureurl" => new external_value(PARAM_TEXT, 'picture url', VALUE_REQUIRED),
                    "themes" => new external_multiple_structure(
                        new external_single_structure([
                            'id' => new external_value(PARAM_TEXT, 'id', VALUE_REQUIRED),
                            'name' => new external_value(PARAM_TEXT, 'name', VALUE_REQUIRED),
                        ])
                    ),
                    "tags" => new external_multiple_structure(
                        new external_single_structure([
                            'id' => new external_value(PARAM_TEXT, 'id', VALUE_REQUIRED),
                            'name' => new external_value(PARAM_TEXT, 'name', VALUE_REQUIRED),
                        ])
                    ),
                    "fixed_tags" => new external_multiple_structure(
                        new external_single_structure([
                            'name' => new external_value(PARAM_TEXT, 'name', VALUE_REQUIRED),
                        ])
                    ),
                    "reactions" => new external_single_structure([
                        "likes" => new external_single_structure([
                            "count" => new external_value(PARAM_TEXT, 'likes', VALUE_REQUIRED),
                            "data" => new external_multiple_structure(
                                new external_single_structure([])
                            )
                        ]),
                        "dislikes" => new external_single_structure([
                            "count" => new external_value(PARAM_TEXT, 'likes', VALUE_REQUIRED),
                            "data" => new external_multiple_structure(
                                new external_single_structure([])
                            )
                        ]),
                        "comments" => new external_single_structure([
                            "count" => new external_value(PARAM_TEXT, 'likes', VALUE_REQUIRED),
                            "data" => new external_multiple_structure(
                                new external_single_structure([])
                            )
                        ]),
                        "reports" => new external_single_structure([
                            "count" => new external_value(PARAM_TEXT, 'likes', VALUE_REQUIRED),
                            "data" => new external_multiple_structure(
                                new external_single_structure([])
                            )
                        ])
                    ])
                ])
            ),
            "viewurl" => new external_value(PARAM_TEXT, 'view url', VALUE_REQUIRED)
        ]);
    }
}