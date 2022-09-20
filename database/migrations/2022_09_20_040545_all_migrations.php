<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //

        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('nik');
            $table->string('name');
            $table->string('address');
            $table->string('phone');
            $table->string('email');
            $table->string('roles');
            $table->string('emergency_name');
            $table->string('emergency_phone');
            $table->date('join_date');
            $table->date('exit_date');
            $table->string('note');
            $table->integer('users_id');
            $table->integer('branches_id')->nullable();
            $table->integer('created_by')->nullable();
            $table->timestamps();
        });


        Schema::create('managers', function (Blueprint $table) {
            $table->id();
            $table->integer('employees_id');
            $table->integer('branches_id')->nullable();
            $table->string('note');
            $table->integer('created_by')->nullable();
            $table->timestamps();
        });


        Schema::create('branches', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('address');
            $table->string('phone');
            $table->integer('managers_id')->nullable();
            $table->string('email');
            $table->date('open_date');
            $table->string('status')->nullable();
            $table->integer('created_by')->nullable();
            $table->timestamps();
        });


        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->integer('branches_id');
            $table->string('expense_type');
            $table->string('description');
            $table->integer('amount');
            $table->date('date');
            $table->string('approve_by')->nullable();
            $table->integer('created_by')->nullable();
            $table->timestamps();
        });


        Schema::create('rentals', function (Blueprint $table) {
            $table->id();
            $table->integer('branches_id');
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('amount');
            $table->string('owner_name');
            $table->string('owner_phone');
            $table->string('notaris_name');
            $table->string('notaris_phone');
            $table->integer('created_by')->nullable();
            $table->timestamps();
        });


        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->string('item_name');
            $table->integer('qty');
            $table->integer('cost');
            $table->string('note');
            $table->integer('created_by')->nullable();
            $table->timestamps();
        });


        Schema::create('parents', function (Blueprint $table) {
            $table->id();
            $table->string('nik')->nullable();
            $table->string('name');
            $table->string('address');
            $table->string('phone');
            $table->string('email')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('emergency_name')->nullable();
            $table->string('emergency_phone')->nullable();
            $table->string('bank_account_name')->nullable();
            $table->string('virtual_account_name')->nullable();
            $table->string('note')->nullable();
            $table->integer('user_id')->nullable();
            $table->string('blacklist')->nullable();
            $table->integer('created_by')->nullable();
            $table->timestamps();
        });


        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->integer('parents_id');
            $table->integer('schools_id');
            $table->string('grade');
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->string('address');
            $table->date('join_date');
            $table->date('exit_date');
            $table->string('exit_reason');
            $table->date('birth_date');
            $table->string('type');
            $table->string('health_condition');
            $table->string('note');
            $table->integer('created_by')->nullable();
            $table->timestamps();
        });


        Schema::create('schools', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('type')->nullable();
            $table->string('color_code')->nullable();
            $table->integer('created_by')->nullable();
            $table->timestamps();
        });


        Schema::create('pricelists', function (Blueprint $table) {
            $table->id();
            $table->date('start_date');
            $table->date('end_date');
            $table->string('level');
            $table->string('school_type');
            $table->string('subject');
            $table->integer('price');
            $table->string('week');
            $table->integer('branches_id');
            $table->integer('created_by')->nullable();
            $table->timestamps();
        });


        Schema::create('promolists', function (Blueprint $table) {
            $table->id();
            $table->date('start_date');
            $table->date('end_date');
            $table->string('label');
            $table->string('discount_value');
            $table->integer('branches_id');
            $table->integer('created_by')->nullable();
            $table->timestamps();
        });


        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->integer('students_id');
            $table->integer('branches_id');
            $table->date('date');
            $table->string('reference');
            $table->integer('cashback');
            $table->string('status')->nullable();
            $table->string('note')->nullable();
            $table->integer('created_by')->nullable();
            $table->timestamps();
        });


        Schema::create('registrationitems', function (Blueprint $table) {
            $table->id();
            $table->integer('registrations_id');
            $table->integer('pricelists_id')->nullable();
            $table->integer('promolists_id')->nullable();
            $table->string('charges');
            $table->integer('price')->nullable();
            $table->string('discount_amount')->nullable();
            $table->integer('created_by')->nullable();
            $table->timestamps();
        });


        Schema::create('salaries', function (Blueprint $table) {
            $table->id();
            $table->integer('employees_id');
            $table->integer('amount');
            $table->date('start_date');
            $table->date('end_date');
            $table->string('note');
            $table->integer('created_by')->nullable();
            $table->timestamps();
        });


        Schema::create('advisors', function (Blueprint $table) {
            $table->id();
            $table->integer('employees_id');
            $table->string('note');
            $table->integer('created_by')->nullable();
            $table->timestamps();
        });


        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->integer('employees_id');
            $table->string('subject');
            $table->string('note');
            $table->integer('created_by')->nullable();
            $table->timestamps();
        });


        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            $table->integer('teachers_id');
            $table->string('subject');
            $table->string('school');
            $table->integer('created_by')->nullable();
            $table->timestamps();
        });


        Schema::create('employeeroles', function (Blueprint $table) {
            $table->id();
            $table->integer('employees_id');
            $table->string('role_title');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->integer('created_by')->nullable();
            $table->timestamps();
        });


        Schema::create('roletypes', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->integer('created_by')->nullable();
            $table->timestamps();
        });


        Schema::create('actionhistories', function (Blueprint $table) {
            $table->id();
            $table->string('action');
            $table->integer('created_by')->nullable();
            $table->timestamps();
        });


        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->date('day');
            $table->string('time_slot');
            $table->string('subject');
            $table->string('classroom');
            $table->string('duration');
            $table->date('date');
            $table->integer('created_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
