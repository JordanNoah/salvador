<?php

class external_cases_get_used_langs extends external_api
{
    public static function cases_get_used_langs_parameters()
    {
        return new external_function_parameters(
            array()
        );
    }

    public static function cases_get_used_langs()
    {
        global $DB;

        $sql = "SELECT DISTINCT lang FROM {digitalta_cases} WHERE lang IS NOT NULL and status = 1";
        $langs = array_keys($DB->get_records_sql($sql));
        return $langs;
    }

    public static function cases_get_used_langs_returns()
    {
        return new external_multiple_structure(
            new external_value(PARAM_TEXT, 'lang')
        );
    }
}