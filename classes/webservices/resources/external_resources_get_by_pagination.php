<?php

defined('MOODLE_INTERNAL') || die();
require_once($CFG->dirroot . '/local/digitalta/classes/resources.php');
require_once($CFG->dirroot . '/local/digitalta/classes/resource.php');

class external_resources_get_by_pagination extends external_api
{
    public static function resources_get_by_pagination_parameters()
    {
        return new external_function_parameters(
            [
                'pagenumber' => new external_value(PARAM_INT, 'page number', VALUE_REQUIRED),
                'filters' => new external_value(PARAM_TEXT, 'filters', VALUE_REQUIRED)
            ]
        );
    }

    public static function resources_get_by_pagination($pagenumber, $filters)
    {
        global $DB, $CFG;

        $limit = 5;
        $totalPages = 0;

        $filters = json_decode($filters, true);

        $resources = array();

        if (count($filters) > 0) {
            $resourceTypes = [];
            $themes = [];
            $tags = [];
            $authors = [];
            $langs = [];


            for ($i = 0; $i < count($filters); $i++) {
                $filter = $filters[$i];
                if ($filter["type"] == "tag") {
                    $tags[] = '"' . $filter["value"] . '"';
                } else if ($filter["type"] == "theme") {
                    $themes[] = $filter["value"];
                } else if ($filter["type"] == "author") {
                    $authors[] = '"' . $filter["value"] . '"';
                } else if ($filter["type"] == "languaje") {
                    $langs[] = '"' . $filter["value"] . '"';
                } else if ($filter["type"] == "resource") {
                    $resourceTypes[] = $filter["value"];
                }
            }
            $havingSum = "";

            if (count($themes) > 0) {
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
                $sqlComponent = 'SELECT * FROM mdl_digitalta_resources where ';
                $sqlTotalRows = 'SELECT COUNT(*) AS total  FROM mdl_digitalta_resources where ';
                for ($i = 0; $i < count($componentInstanceIds); $i++) {
                    if ($i === 0){
                        $sqlComponent .= '( ';
                        $sqlTotalRows .= '( ';
                    }
                    $sqlComponent .= 'path like "%id='.$componentInstanceIds[$i].'%" OR ';
                    $sqlTotalRows .= 'path like "%id='.$componentInstanceIds[$i].'%" OR ';
                    if($i+1 == count($componentInstanceIds)){
                        $sqlComponent = preg_replace('/\s+OR\s*$/', '', $sqlComponent);
                        $sqlTotalRows = preg_replace('/\s+OR\s*$/', '', $sqlTotalRows);
                        $sqlComponent .= ' )';
                        $sqlTotalRows .= ' )';
                    }
                }
                if (count($authors) > 0) {
                    for ($i = 0; $i < count($authors); $i++) {
                        $sqlComponent .= ' and userid = ' . $authors[$i];
                        $sqlTotalRows .= ' and userid = ' . $authors[$i];
                    }
                }

                if (count($langs) > 0) {
                    for ($i = 0; $i < count($langs); $i++) {
                        $sqlComponent .= ' and lang like ' . $langs[$i];
                        $sqlTotalRows .= ' and lang like ' . $langs[$i];
                    }
                }

                if (count($resourceTypes) > 0) {
                    for ($i = 0; $i < count($resourceTypes); $i++) {
                        $sqlComponent .= ' and type = ' . $resourceTypes[$i];
                        $sqlTotalRows .= ' and type = ' . $resourceTypes[$i];
                    }
                }

                $sqlComponent .= ' ORDER BY timecreated DESC limit ' . $limit . ' offset ' . (($pagenumber - 1) * $limit);

                $components = array_values($DB->get_records_sql($sqlComponent));

                $totalRows = $DB->get_record_sql($sqlTotalRows)->total;

                $totalPages = ceil($totalRows / $limit);

                $resources = self::get_resources($components);
            }
        } else {
            $components = array_values(
                $DB->get_records_sql(
                    "SELECT * FROM mdl_digitalta_resources ORDER BY timecreated DESC LIMIT " . $limit . " OFFSET " . (($pagenumber - 1) * $limit)
                )
            );

            $totalRows = $DB->count_records('digitalta_resources');
            $totalPages = ceil($totalRows / $limit);
            $resources = self::get_resources($components);
        }

        return array(
            'data' => $resources,
            'pages' => $totalPages,
            'pagenumber' => $pagenumber
        );
    }

    public static function get_resources($components)
    {
        $resources = array();

        for ($i = 0; $i < count($components); $i++) {
            $resource = $components[$i];
            $resource_model = new \local_digitalta\Resource($resource);
            $x = \local_digitalta\Resources::get_extra_fields($resource_model);

            [$x->type, $x->type_simplified] = local_digitalta_get_element_translation(
                'resource_type',
                \local_digitalta\Resources::get_type($x->type)->name
            );

            $resources[] = $x;
        }

        return $resources;
    }

    public static function resources_get_by_pagination_returns()
    {
        return new external_single_structure([
            'data' => new external_multiple_structure(
                new external_single_structure([
                    "id" => new external_value(PARAM_INT, "id"),
                    "name" => new external_value(PARAM_TEXT, "name"),
                    "description" => new external_value(PARAM_CLEANHTML, "description"),
                    "type" => new external_value(PARAM_TEXT, "type"),
                    "format" => new external_value(PARAM_TEXT, "format"),
                    "path" => new external_value(PARAM_TEXT, "path"),
                    "lang" => new external_value(PARAM_TEXT, "lang"),
                    "userid" => new external_value(PARAM_INT, "userid"),
                    "timecreated" => new external_value(PARAM_INT, "timecreated"),
                    "timemodified" => new external_value(PARAM_INT, "timemodified"),
                    "comment" => new external_value(PARAM_TEXT, "comment"),
                    "themes" => new external_multiple_structure(new external_single_structure([])),
                    "tags" => new external_multiple_structure(new external_single_structure([])),
                    "fixed_tags" => new external_multiple_structure(
                        new external_single_structure([
                            "name" => new external_value(PARAM_TEXT, "name")
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
                    "type_simplified" => new external_value(PARAM_TEXT, "type_simplified"),
                ])
            ),
            'pages' => new external_value(PARAM_INT, 'pages'),
            'pagenumber' => new external_value(PARAM_INT, 'pagenumber')
        ]);
    }
}