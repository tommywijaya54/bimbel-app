<?php

namespace App; // <- important

use Closure;

class FieldSchema
{
    public $entityname;
    public $value;

    public $label;
    public $inputtype;
    public $element;
    public $options;
    public $className = '';
    public $required = true;

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
        } else {

            // get entityname:label|nr|ex

            $arr = explode(":", $StringField);
            $entityname = explode("|", $arr[0]);

            // default label & input type;
            $this->entityname = $entityname[0];

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

            if (str_contains($StringField, '|')) {
                if (str_contains($StringField, '|nr')) {
                    $this->required = false;
                }
                if (str_contains($StringField, '|ex')) {
                    $this->extrafield = false;
                }
            }

            if (isset($arr[1])) {
                $label = explode('|', $arr[1]);
                if (isset($label[0]) && $label[0] != '') {
                    $this->label = $label[0];
                }
            }
        }
    }

    public function identify()
    {
    }

    public function hasOptions($options, $inputtype = 'select')
    {
        $this->options = $options;
        $this->inputtype = $inputtype;
        return $this;
    }
}
