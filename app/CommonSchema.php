<?php

namespace App; // <- important

class CommonSchema
{
    protected $original_string;
    protected $string_of_fields;

    public $modal;
    public $model;
    public $fields;

    public $with_list = [];
    public $title;
    public $title_format = '{id}';
    public $item_url;

    function __construct($StringOfFields = null, $modal = null, $model = null)
    {
        if ($StringOfFields) {
            $this->original_string = $StringOfFields;
            $this->string_of_fields = array_map(function ($string) {
                return trim($string);
            }, explode(',', $this->original_string));
        }

        $this->modal = $modal;
        $this->model = $model;

        $this->fields = array_map(function ($string_field) {
            $field = new FieldSchema($string_field);
            if (isset($field->model)) {
                array_push($this->with_list, $field->model);
            }
            return $field;
        }, $this->string_of_fields);

        // dd(get_class($this));
        // $schema_name = substr(get_class($this), strrpos(get_class($this), '\\') + 1);
        // if ($schema_name == 'ListSchema') {
        // }
    }
}
