<?php

namespace App; // <- important

use Closure;

class FieldSchema
{
    // protected $form;

    public $entityname;
    public $value;

    public $label;
    public $inputtype;
    public $element;
    public $options;

    // public $getValue;

    // public $model;
    // public $model_value;
    public function __call($method, $arguments)
    {
        return call_user_func_array(Closure::bind($this->$method, $this, get_called_class()), $arguments);
    }

    function __construct($StringField, $form = null)
    {
        if ($form) {
            $this->form = $form;
        }

        // field schema -> entityname:label:inputtype
        if ($StringField == null) {
            $this->element = 'row';
        } elseif ($StringField == "_") {
            $this->element = 'line';
        } elseif ($StringField == "--") {
            $this->element = 'next-full-with';
        } else {
            $arr = explode(":", $StringField);

            // default label & input type;
            $this->entityname = $arr[0];
            $this->label = ucwords(str_replace('_', ' ', $this->entityname));
            $this->inputtype = 'text';

            // check default type base on entity
            if (str_contains($this->entityname, 'date')) {
                $this->inputtype = 'date';
            } else if (str_contains($this->entityname, 'email')) {
                $this->inputtype = 'email';
            } else if (str_contains($this->entityname, 'note')) {
                $this->inputtype = 'textarea';
            } else if (str_contains($this->entityname, '_id')) {
                $this->label = ucwords(str_replace('_id', '', $this->entityname));
                $this->inputtype = 'datalist';
                $this->model = str_replace('_id', '', $this->entityname);
                $this->route = [
                    'show' => $this->model . '.show'
                ];
            }

            if (isset($arr[1])) {
                if (str_contains($arr[1], '-')) {
                    $options = explode('-', $arr[1]);
                    foreach ($options as $key => $option) {
                        if (isset($option) && $option != "") {
                            $opt = explode('=', $option);
                            if ($opt[0] == "inputtype") {
                                $this->inputtype = $opt[1];
                            } else if ($opt[0] == "model") {
                                $this->model = $opt[1];
                            } else if ($opt[0] == 'extrafield') {
                                $this->extrafield = $opt[1];
                            } else if ($opt[0] == 'label') {
                                $this->label = $opt[1];
                            }
                        }
                    }
                } else {
                    $this->label = $arr[1];
                }
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
