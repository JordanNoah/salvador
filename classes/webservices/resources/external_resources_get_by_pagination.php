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