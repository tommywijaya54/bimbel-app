<?php

namespace App; // <- important

use function PHPUnit\Framework\stringStartsWith;

class FormField
{
    public $entityname;
    public $value;

    public $label;
    public $inputtype;
    public $element;
    public $options;

    // public $model;
    // public $model_value;

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

            // label assignment
            /*
            if (!isset($arr[1])) {
                $this->label = $arr[1] ?? ucwords(str_replace('_', ' ', $this->entityname)); // set label -> if label has _ then change it into space
            }
            */

            if (isset($arr[1]) && $arr[1] != '') {
                $this->label = $arr[1];
            } else {
                $this->label = ucwords(str_replace('_', ' ', $this->entityname));
            }

            // type assigning
            $this->inputtype = $arr[2] ?? 'text';
            if (str_contains($this->entityname, '_date')) {
                $this->inputtype = 'date';
            }
            if (str_contains($this->entityname, 'date')) {
                $this->inputtype = 'date';
            }

            if (str_contains($this->entityname, '_id')) {
                $this->label = ucwords(str_replace('_id', '', $this->entityname));
                $this->inputtype = 'datalist';
                $this->model = str_replace('_id', '', $this->entityname);
            }

            if (str_contains($this->entityname, 'note')) {
                $this->inputtype = 'textarea';
            }
        }
    }

    public function hasOptions($options, $inputtype = 'select')
    {
        $this->options = $options;
        $this->inputtype = $inputtype;
        return $this;
    }
}

class FormSchema
{
    protected $original_string;
    protected $string_of_fields;

    // public $options; // create/edit/display_form

    public $id;
    public $fields;
    public $submit_url;
    public $form_type;
    public $modal;

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

    public function field($entityname)
    {
        $found_key = array_search($entityname, array_column($this->fields, 'entityname'));
        // print_r($this->fields);
        // print_r($found_key);
        // print_r($this->fields[$found_key]);

        return $this->fields[$found_key];
    }

    public function alter($entityname, $changes)
    {
        $found_key = array_search($entityname, array_column($this->fields, 'entityname'));
        $this->fields[$found_key] = $changes($this->fields[$found_key]);
    }

    // for display and edit view
    public function withValue($data)
    {
        // print_r($this->fields);

        // print_r($data['student']->toArray());

        // print_r($data);

        //$arr = $data->getOriginal();
        //print_r($arr);

        $this->id = $data['id'];

        // print_r($this->fields);

        foreach ($this->fields as $key => $field) {
            if (str_contains($field->entityname, '_id')) {
                $model = str_replace('_id', '', $field->entityname);
                $field->model_value = $data[$model];
                /*
                if ($data[$model]) {
                    $new_field = new FormField($model);
                    $new_field->value = $data[$model];

                    
                    // $this->addField($model);
                    // $this->field($model)->value = ;
                    // $field->value = $data[$model];
                }
                */

                // print_r($field->model_value['name']);
                // print_r($field);

                // print_r($data[$field->entityname]);

                // $found_key = array_search($data[$field->entityname], array_column($field->model_value, 'id'));
                // var_dump($found_key);
                //  print_r($found_key);

                $field->value = $data[$field->entityname] . " : " . $field->model_value['name'];
            } else if ($field->entityname) {
                $field->value = $data[$field->entityname];
            }



            // print_r($field);
            // print_r($field->entityname, $arr[$field->entityname]);
            // $field->value = $arr[$field->entityname];
        }

        return $this;
    }

    public function addField($field_string)
    {
        array_push($this->fields, new FormField($field_string));
        return $this;
    }
    public function removeField()
    {
    }

    public function displayForm()
    {
        $this->display_form = true;
        $this->form_type = "display";

        /*
        $form = $this;

        // change _id to object
        foreach ($form->fields as $field) {
            if ($field->entityname && str_contains($field->entityname, '_id')) {
            }
        }
        */

        return $this;
    }
    public function createForm()
    {
        $this->create_form = true;
        $this->form_type = "create";
        $this->submit_url = '/' . $this->modal;

        return $this;
    }

    public function editForm()
    {
        $this->edit_form = true;
        $this->form_type = "edit";
        $this->submit_url = "/" . $this->modal . "/" . $this->id;

        return $this;
    }

    public function setStoreOrUpdate($request = null, $entity = [])
    {
        foreach ($this->fields as $field) {
            if ($field->entityname) {
                if ($request[$field->entityname]) {
                    $entity[$field->entityname] = $request[$field->entityname];
                }
            }
        }
        return $entity;
    }
    public function setUpdate($request, $entity)
    {
    }

    public function recordHistory()
    {
    }
}
