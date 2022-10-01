<?php

namespace App; // <- important

class FieldSchema
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

            if (isset($arr[1]) && $arr[1] != '') {
                $this->label = $arr[1];
            } else {
                $this->label = ucwords(str_replace('_', ' ', $this->entityname));
            }

            // type assigning
            $this->inputtype = $arr[2] ?? 'text';
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
