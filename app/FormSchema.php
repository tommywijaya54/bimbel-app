<?php

namespace App; // <- important

use function PHPUnit\Framework\stringStartsWith;

class FormField
{
    public $entityname;
    public $label;
    public $inputtype;
    public $element;
    public $options;

    public $value;

    function __construct($StringField)
    {
        // field schema -> entityname:label:inputtype
        if ($StringField == null) {
            $this->element = 'row';
        } elseif ($StringField == "_") {
            $this->element = 'line';
        } else {
            $arr = explode(":", $StringField);
            $this->entityname = $arr[0];
            $this->label = $arr[1] ?? ucwords(str_replace('_', ' ', $this->entityname)); // set label -> if label has _ then change it into space
            $this->inputtype = $arr[2] ?? 'text';
        }
    }
}

class FormSchema
{
    protected $original_string;
    protected $string_of_fields;
    protected $modal;

    // public $options; // create/edit/display_only

    public $id;
    public $fields;
    public $submit_url;
    public $display_only;

    function __construct($StringOfFields = null, $modal = null)
    {
        if ($StringOfFields) {
            $this->original_string = $StringOfFields;
            $this->string_of_fields = explode(',', $this->original_string);
        }

        $this->modal = $modal;

        $this->fields = array_map(function ($string_field) {
            return new FormField($string_field);
        }, $this->string_of_fields);
    }

    public function alter($entityname, $changes)
    {
        $found_key = array_search($entityname, array_column($this->fields, 'entityname'));
        $this->fields[$found_key] = $changes($this->fields[$found_key]);
    }

    // for display and edit view
    public function withValue($data)
    {
        $arr = $data->getOriginal();

        $this->id = $arr['id'];
        $this->submit_url = "/" . $this->modal . "/" . $this->id;

        foreach ($this->fields as $field) {
            $field->value = $arr[$field->entityname];
        }

        // if ($data['id']) {}
        // dd($data, $data->getOriginal());

        // print_r($arr);
        /*
        foreach ($arr as $key => $value) {
            $found_key = array_search($key, array_column($this->fields, 'entityname'));
            // var_dump("<br>found_key", $found_key, " : key -> ", $key);

            if ($found_key != false) {
                var_dump($found_key . ' -> ' . $this->fields[$found_key]->value);
                $this->fields[$found_key]->value = $value; //"CPA-613-369-762"; // $value;
                var_dump($this->fields[$found_key]->value);
            }
        }*/

        // $this->fields[0]->value = "Hello";
        // $this->fields[false]->value = "Hello False";

        // print_r($this->fields);
        // die();
        return $this;
    }

    public function displayOnly()
    {
        $this->display_only = true;
        return $this;
    }
}
