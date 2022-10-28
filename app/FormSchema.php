<?php

namespace App; // <- important

use App\Models\Cparent;
use Illuminate\Database\Schema\ColumnDefinition;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Closure;

class FormSchema extends CommonSchema
{
    // public $options; // create/edit/display_form

    public $id;
    public $submit_url;
    public $form_type;
    public $data;
    public $beforeRender = [];

    public function __call($method, $arguments)
    {
        return call_user_func_array(Closure::bind($this->$method, $this, get_called_class()), $arguments);
    }

    function __construct($StringOfFields = null, $modal = null, $model = null)
    {
        parent::__construct($StringOfFields, $modal, $model);

        $this->validate = [
            'store' => $this->generateValidationData(),
            'update' => $this->generateValidationData()
        ];
    }

    public function field($entityname)
    {
        $found_key = array_search($entityname, array_column($this->fields, 'entityname'));
        return $this->fields[$found_key];
    }

    public function getField($entitynames = [], $func = null, $elseFunc = null)
    {
        // $field_entitynames = collect($entitynames);
        $fields = collect($this->fields);

        $selected_fields = $fields->filter(function ($field) use ($entitynames) {
            return in_array($field->entityname, $entitynames);
        })->each(function ($field) use ($func) {
            $func($field);
        });

        if ($elseFunc) {
            $else_fields = $fields->filter(function ($field) use ($entitynames) {
                return !in_array($field->entityname, $entitynames);
            })->each(function ($field) use ($elseFunc) {
                $elseFunc($field);
            });

            return [
                'selected_fields' => $selected_fields,
                'else_fields' => $else_fields
            ];
        }
        return $selected_fields;
    }

    public function generateValidationData()
    {
        $fields = collect($this->fields);

        $validationData = $fields->filter(function ($field) {
            return $field->required;
        })->reduce(function ($validationData, $field) {
            $validationData[$field->entityname] = 'required';
            return $validationData;
        }, []);

        return $validationData;
    }


    public function alter($entityname, $changes)
    {
        $found_key = array_search($entityname, array_column($this->fields, 'entityname'));
        $this->fields[$found_key] = $changes($this->fields[$found_key]);
    }

    // for display and edit view
    public function addValueToField($data)
    {
        foreach ($this->fields as $key => $field) {
            if (isset($field->getValue)) {
                $field->value = $field->getValue($field, $this->id, $data);
            } else if (str_contains($field->entityname, '_id')) {
                $model = str_replace('_id', '', $field->entityname);
                $field->model_value = $data[$model];
                $field->value = $field->model_value['id'];
            } else if ($field->entityname && isset($data[$field->entityname])) {
                $field->value = $data[$field->entityname];
            }
        }
        return $this;
    }

    public function setDataById($id)
    {
        // Get Data from model base on their Id
        if (isset($this->with_list)) {
            $this->entity_item = $this->model::with($this->with_list)->find($id);
            $this->data = $this->entity_item->toArray();;
        } else {
            $this->entity_item = $this->model::find($id);
            $this->data = $this->entity_item->toArray();;
        }

        // set form id
        $this->id = $this->data['id'];

        // set value to field, using the data that we retrieve
        $this->addValueToField($this->data);

        // set form title
        $this->title = $this->title_format;
        $titlePlacehoder = explode('{', $this->title_format);
        foreach ($titlePlacehoder as $placeholder) {
            if (isset($placeholder) && $placeholder != "") {
                $p = explode('}', $placeholder)[0];
                $this->title = str_replace('{' . $p . '}', $this->data[$p], $this->title);
            }
        }
    }

    public function retriveFieldOptions()
    {
        $fields_has_model = array_filter($this->fields, function ($field) {
            return (isset($field->model) && empty($field->options));
        });

        foreach ($fields_has_model as $field) {
            $this->field($field->entityname)->hasOptions(
                ('App\\Models\\' . ucfirst($field->model))::all(['id', 'name'])->toArray(),
                'datalist'
            );
        }
    }

    public function createForm()
    {
        $this->retriveFieldOptions();
        $this->create_form = true;
        $this->title = 'Create ' . $this->modal . ' Form';
        $this->form_type = "create";
        $this->submit_url = '/' . $this->modal;
        return $this;
    }

    public function displayForm($id)
    {
        $this->setDataById($id);
        $this->display_form = true;
        $this->form_type = "display";
        return $this;
    }

    public function editForm($id)
    {
        $this->retriveFieldOptions();
        $this->setDataById($id);

        $this->edit_form = true;
        $this->form_type = "edit";
        $this->submit_url = "/" . $this->modal . "/" . $this->id;
        return $this;
    }

    public function setStoreOrUpdate($request = null, $entity = [])
    {
        foreach ($this->fields as $field) {
            if ($field->entityname && !isset($field->extrafield)) {
                //if ($request[$field->entityname]) {
                $entity[$field->entityname] = $request[$field->entityname];
                //}
            }
        }
        return $entity;
    }
}
