<?php

defined('MOODLE_INTERNAL') || die();
require_once($CFG->dirroot . '/local/digitalta/classes/case.php');
require_once($CFG->dirroot . '/local/digitalta/classes/cases.php');

class external_cases_get_by_pagination extends external_api
{
    public static function cases_get_by_pagination_parameters()
    {
        return new external_function_parameters(
            [
                'pagenumber' => new external_value(PARAM_INT, 'page number', VALUE_REQUIRED),
                'filters' => new external_value(PARAM_TEXT, 'filters', VALUE_REQUIRED)
            ]
        );
    }

    public static function cases_get_by_pagination($pagenumber, $filters){
        global $DB, $USER, $CFG;

        $limit = 5;
        $totalPages = 0;

        $filters = json_decode($filters, true);

        $cases = array();

        if (count($filters) > 0){
            $tags = [];
            $themes = [];
            $authors = [];
            $langs = [];

            for ($i = 0; $i < count($filters); $i++) {
                $filter = $filters[$i];
                if ($filter["type"] == "tag"){
                    $tags[] = '"'.$filter["value"].'"';
                }else if ($filter["type"] == "theme"){
                    $themes[] = $filter["value"];
                }else if ($filter["type"] == "author"){
                    $authors[] = '"'.$filter["value"].'"';
                }else if ($filter["type"] == "languaje"){
                    $langs[] = '"'.$filter["value"].'"';
                }
            }

            $havingSum = "";

            if (count($themes) > 0){
                for ($i = 0; $i < count($themes); $i++) {
                    if (strlen($havingSum) == 0){
                        $havingSum .= "HAVING SUM(CASE WHEN modifier = 1 AND modifierinstance = ".$themes[$i]." THEN 1 ELSE 0 END) > 0 AND ";
                    }else{
                        $havingSum .= "SUM(CASE WHEN modifier = 1 AND modifierinstance = ".$themes[$i]." THEN 1 ELSE 0 END) > 0 AND ";
                    }
                }
            }

            if (count($tags) > 0){
                $tagsToSearch = '(' . implode(', ', $tags) . ')';
                $tagsExperiences = $DB->get_records_sql(
                    "SELECT * FROM mdl_digitalta_tags where name IN ".$tagsToSearch
                );
                $tagsId = array_keys($tagsExperiences);
                for ($i = 0; $i < count($tagsId); $i++) {
                    if (strlen($havingSum) == 0){
                        $havingSum .= "HAVING SUM(CASE WHEN modifier = 2 AND modifierinstance = ".$tagsId[$i]." THEN 1 ELSE 0 END) > 0 AND ";
                    }else{
                        $havingSum .= "SUM(CASE WHEN modifier = 2 AND modifierinstance = ".$tagsId[$i]." THEN 1 ELSE 0 END) > 0 AND ";
                    }
                }
            }

            $query = preg_replace('/\s+AND\s*$/', '', $havingSum);

            $contextDigitalTa = $DB->get_records_sql(
                'WITH FilteredComponentInstances AS ( SELECT componentinstance FROM mdl_digitalta_context where component = 2 GROUP BY componentinstance '.$query.' )
                        SELECT componentinstance, GROUP_CONCAT(modifier) AS modifiers, GROUP_CONCAT(modifierinstance) AS modifierinstances FROM mdl_digitalta_context
                            WHERE componentinstance IN (SELECT componentinstance FROM FilteredComponentInstances) GROUP BY componentinstance;'
            );

            $componentInstanceIds = array_keys($contextDigitalTa);

            if (count($componentInstanceIds) > 0) {
                $componentsInstanceIdsToSearch = '(' . implode(', ', $componentInstanceIds) . ')';

                $sqlComponent = 'SELECT * FROM mdl_digitalta_cases 
                            where id IN '.$componentsInstanceIdsToSearch.' 
                            and status = 1';

                $sqlTotalRows = 'SELECT COUNT(*) AS total  FROM mdl_digitalta_cases where id IN '.$componentsInstanceIdsToSearch;

                if (count($authors) > 0){
                    for ($i = 0; $i < count($authors); $i++) {
                        $sqlComponent .= ' and userid = '.$authors[$i];
                        $sqlTotalRows .= ' and userid = '.$authors[$i];
                    }
                }

                if (count($langs) > 0){
                    for ($i = 0; $i < count($langs); $i++) {
                        $sqlComponent .= ' and lang like '.$langs[$i];
                        $sqlTotalRows .= ' and lang like '.$langs[$i];
                    }
                }

                $sqlComponent .= ' ORDER BY timecreated DESC limit '.$limit.' offset '.(($pagenumber-1) * $limit);

                $components = array_values($DB->get_records_sql(
                    $sqlComponent
                ));

                $totalRows = $DB->get_record_sql(
                    $sqlTotalRows
                )->total;

                $totalPages = ceil($totalRows / $limit);

                $cases = self::get_cases($components);
            }
        } else {
            $components = array_values($DB->get_records_sql(
                'SELECT * FROM mdl_digitalta_cases WHERE status = 1 ORDER BY timecreated DESC LIMIT '.$limit.' OFFSET '. (($pagenumber - 1) * $limit)
            ));

            $totalRows = $DB->count_records('digitalta_cases', ['status' => 1]);

            $totalPages = ceil($totalRows / $limit);

            $cases = self::get_cases($components);
        }

        return array(
            'pagenumber' => $pagenumber,
            'data' => $cases,
            'pages' => $totalPages,
            'viewurl' => $CFG->wwwroot . '/local/digitalta/pages/cases/view.php?id=',
            'manageurl' => $CFG->wwwroot . '/local/digitalta/pages/cases/manage.php?id='
        );
    }

    public static function get_cases($components)
    {
        $cases = array();
        for ($i = 0; $i < count($components); $i++) {
            $case = $components[$i];
            $case_model = new \local_digitalta\StudyCase($case);
            $x = \local_digitalta\Cases::get_extra_fields($case_model);

            $sections = [];

            foreach ($x->sections as $section) {
                $groupname = \local_digitalta\Sections::get_group($section->groupid)->name;
                list($section->groupname, $section->groupname_simplified) =
                    local_digitalta_get_element_translation('section_group', $groupname);
                $section->content = strip_tags($section->content);
                $sections[$section->groupname_simplified] = $section;
            }

            $x->sections = $sections;
            $cases[] = $x;
        }
        return $cases;
    }

    public static function cases_get_by_pagination_returns()
    {
        return new external_single_structure([
            'pagenumber' => new external_value(PARAM_INT, 'page number'),
            'data' => new external_multiple_structure(
                new external_single_structure([
                    'id' => new external_value(PARAM_INT, 'case id'),
                    'experienceid' => new external_value(PARAM_INT, 'experience id'),
                    'resourceid' => new external_value(PARAM_INT, 'resource id'),
                    'userid' => new external_value(PARAM_INT, 'user id'),
                    "title" => new external_value(PARAM_TEXT, 'title'),
                    "description" => new external_value(PARAM_CLEANHTML, 'description'),
                    "lang" => new external_value(PARAM_TEXT, 'language'),
                    "status" => new external_value(PARAM_INT, 'status'),
                    "timecreated" => new external_value(PARAM_INT, 'time created'),
                    "timecreated_string" => new external_value(PARAM_TEXT, 'time created string'),
                    "timemodified" => new external_value(PARAM_INT, 'time modified'),
                    "sections" => new external_multiple_structure(
                        new external_single_structure([
                            "id" => new external_value(PARAM_INT),
                            "component" => new external_value(PARAM_TEXT),
                            "componentinstance" => new external_value(PARAM_TEXT),
                            "groupid" => new external_value(PARAM_TEXT),
                            "sequence" => new external_value(PARAM_TEXT),
                            "type" => new external_value(PARAM_TEXT),
                            "title" => new external_value(PARAM_TEXT),
                            "content" => new external_value(PARAM_TEXT),
                        ])
                    ),
                    "themes" => new external_multiple_structure(
                        new external_single_structure([
                            "name" => new external_value(PARAM_TEXT),
                            "id" => new external_value(PARAM_TEXT),
                        ])
                    ),
                    "tags" => new external_multiple_structure(
                        new external_single_structure([
                            "name" => new external_value(PARAM_TEXT),
                            "id" => new external_value(PARAM_TEXT),
                        ])
                    ),
                    "fixed_tags" => new external_multiple_structure(
                        new external_single_structure([
                            "name" => new external_value(PARAM_TEXT),
                        ])
                    ),
                    "reactions" => new external_single_structure([
                        "likes" => new external_single_structure([
                            "count" => new external_value(PARAM_INT, 'likes count'),
                            "data" => new external_multiple_structure(new external_single_structure([])),
                            "isactive" => new external_value(PARAM_BOOL, 'is active'),
                        ]),
                        "dislikes" => new external_single_structure([
                            "count" => new external_value(PARAM_INT, 'likes count'),
                            "data" => new external_multiple_structure(new external_single_structure([])),
                            "isactive" => new external_value(PARAM_BOOL, 'is active'),
                        ]),
                        "comments" => new external_single_structure([
                            "count" => new external_value(PARAM_INT, 'likes count'),
                            "data" => new external_multiple_structure(new external_single_structure([])),
                        ]),
                        "reports" => new external_single_structure([
                            "count" => new external_value(PARAM_INT, 'likes count'),
                            "data" => new external_multiple_structure(new external_single_structure([])),
                            "isactive" => new external_value(PARAM_BOOL, 'is active'),
                        ]),
                    ]),
                    "user" => new external_single_structure([
                        "id" => new external_value(PARAM_INT, 'user id'),
                        "name" => new external_value(PARAM_TEXT, 'user name'),
                        "email" => new external_value(PARAM_TEXT, 'user email'),
                        "imageurl" => new external_value(PARAM_TEXT, 'user image url'),
                        "profileurl" => new external_single_structure([])
                    ])
                ])
            ),
            'pages' => new external_value(PARAM_INT, 'total pages'),
            'viewurl' => new external_value(PARAM_TEXT, 'view url'),
            'manageurl' => new external_value(PARAM_TEXT, 'manage url')
        ]);
    }
}