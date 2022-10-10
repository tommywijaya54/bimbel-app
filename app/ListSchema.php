<?php

namespace App; // <- important

class ListSchema extends CommonSchema
{
    function __construct($StringOfFields = null, $modal = null, $model = null)
    {
        parent::__construct($StringOfFields, $modal, $model);
        $this->item_url = '/' . $this->modal . '/{id}';
        $this->order_by = 'DESC';
    }

    public function table_format()
    {
        if (isset($this->with_list)) {
            if ($this->order_by == 'ASC') {
                $this->data = $this->model::with($this->with_list)->get();
            } else {
                $this->data = $this->model::with($this->with_list)->orderBy('id', 'DESC')->get();
            }
        } else {
            if ($this->order_by == 'ASC') {
                $this->data = $this->model::all($this->string_of_fields);
            } else {
                $this->data = $this->model::all($this->string_of_fields)->sortByDesc("id");
            }
        }
        return $this;
    }
}
