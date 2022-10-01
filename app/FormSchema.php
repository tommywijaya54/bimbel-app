<?php

namespace App; // <- important

class FormSchema extends CommonSchema
{
    // public $options; // create/edit/display_form

    public $id;
    public $submit_url;
    public $form_type;
    public $data;

    function __construct($StringOfFields = null, $modal = null, $model = null)
    {
        parent::__construct($StringOfFields, $modal, $model);
    }

    public function field($entityname)
    {
        $found_key = array_search($entityname, array_column($this->fields, 'entityname'));
        return $this->fields[$found_key];
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
            if (str_contains($field->entityname, '_id')) {
                $model = str_replace('_id', '', $field->entityname);
                $field->model_value = $data[$model];
                $field->value = $data[$field->entityname] . " : " . $field->model_value['name'];
            } else if ($field->entityname) {
                $field->value = $data[$field->entityname];
            }
        }
        return $this;
    }

    public function setDataFor($id)
    {
        if (isset($this->with_list)) {
            //dd($this->with_list);
            $this->data = $this->model::with($this->with_list)->find($id)->toArray();;
        } else {
            $this->data = $this->model::find($id)->toArray();;
        }
        $this->addValueToField($this->data);


        // set form id
        $this->id = $this->data['id'];

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
        $this->setDataFor($id);
        $this->display_form = true;
        $this->form_type = "display";
        return $this;
    }

    public function editForm($id)
    {
        $this->retriveFieldOptions();
        $this->setDataFor($id);
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
}
