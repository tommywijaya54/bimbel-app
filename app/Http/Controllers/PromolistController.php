<?php

namespace App\Http\Controllers;

// use App\Models\Promolist;

use App\ListSchema;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class PromolistController extends CommonController
{
    //
    protected $entity = 'App\\Models\\Promolist';

    /*
    function __construct()
    {
        // dd($this);
        //dd((new $this->entity())::getTable());

        // $tablename = with(new $this->entity)->getTable();
        // dd($table);
        // $tablecolumn = Schema::getColumnListing($tablename);

        /*
        $table->integer('student_id');
        $table->integer('branch_id');
        $table->date('date');
        $table->string('reference');
        $table->integer('cashback');
        $table->string('status')->nullable();
        $table->string('note')->nullable();
        
    }
    */

    function __construct()
    {
        $this->model_name = str_replace('Controller', '', get_class($this));
        // $this->entity = 'App\\Models\\' . $this->model_name;
        $this->modal = strtolower($this->model_name);

        // $this->entity = ('App\\Models\\' . $this->model_name)::class;

        $this->table_name = with(new $this->entity)->getTable();
        $this->all_table_column = Schema::getColumnListing($this->table_name);
        $this->list = new ListSchema('id', $this->modal, $this->entity);

        //$this->list->include(['student', 'branch']);
        /*
        $this->form_schema = new FormSchema('date,,student_id,branch_id,reference,cashback::number,status,note', $this->modal);
        $this->form_schema->field('student_id')->hasOptions(Student::all(['id', 'name'])->toArray(), 'datalist');
        $this->form_schema->field('branch_id')->hasOptions(Branch::all(['id', 'name'])->toArray(), 'datalist');
        */
    }
}
