<?php

namespace App; // <- important

class ListSchema
{
    protected $original_string;
    protected $string_of_fields;
    protected $model;
    protected $fields;
    protected $include;

    public $header;

    function __construct($StringOfFields = null, $modal = null, $model = null)
    {
        if ($StringOfFields) {
            $this->original_string = $StringOfFields;
            $this->string_of_fields = explode(',', $this->original_string);
        }

        $this->fields = array_map(function ($string_field) {
            return new FieldSchema($string_field);
        }, $this->string_of_fields);

        $this->header = $this->fields;

        $this->modal = $modal;
        $this->model = $model;
        $this->item_url = '/' . $modal . '/{id}';
    }

    public function include($withList)
    {
        $this->include = $withList;
    }

    public function table_format()
    {
        if (isset($this->include)) {
            $this->data = $this->model::with($this->include)->get();
        } else {
            $this->data = $this->model::all($this->header);
        }
        return $this;
    }
}
