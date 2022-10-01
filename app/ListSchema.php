<?php

namespace App; // <- important

class ListSchema
{
    protected $original_string;
    protected $string_of_fields;
    protected $model;
    protected $fields;
    protected $with_list = [];

    public $header;

    function __construct($StringOfFields = null, $modal = null, $model = null)
    {
        $StringOfFields = str_replace(' ', '', $StringOfFields);

        if ($StringOfFields) {
            $this->original_string = $StringOfFields;
            $this->string_of_fields = explode(',', $this->original_string);
        }

        $this->modal = $modal;
        $this->model = $model;
        $this->item_url = '/' . $modal . '/{id}';

        $this->fields = array_map(function ($string_field) {
            $field = new FieldSchema($string_field);

            if (isset($field->model)) {
                array_push($this->with_list, $field->model);
            }

            return $field;
        }, $this->string_of_fields);

        $this->header = $this->fields;
    }

    public function table_format()
    {
        if (isset($this->with_list)) {
            $this->data = $this->model::with($this->with_list)->orderBy('id', 'DESC')->get();
        } else {
            $this->data = $this->model::all($this->string_of_fields)->sortByDesc("id");
        }
        return $this;
    }
}
