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

        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();

            $table->string('name');

            $table->string('nik')->nullable();
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('emergency_name')->nullable();
            $table->string('emergency_phone')->nullable();
            $table->date('join_date')->nullable();
            $table->date('exit_date')->nullable();
            $table->string('note')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('branch_id')->nullable();
        });

        Schema::create('branches', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();

            $table->string('name');

            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->integer('manager_id')->nullable();
            $table->string('email')->nullable();
            $table->date('open_date')->nullable();
            $table->string('status')->nullable();
        });

        Schema::create('branch_expenses', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();

            $table->integer('branch_id');
            $table->date('date');
            $table->string('expense_type');
            $table->integer('amount');

            $table->string('description')->nullable();
            $table->string('approve_by')->nullable();
            $table->string('note')->nullable();
        });

        Schema::create('branch_rentals', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();

            $table->integer('branch_id');
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('amount');
            $table->string('owner_name');
            $table->string('owner_phone');
            $table->string('notaris_name')->nullable();
            $table->string('notaris_phone')->nullable();
            $table->string('note')->nullable();
        });

        Schema::create('branch_assets', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();

            $table->integer('branch_id');
            $table->date('purchase_date');
            $table->string('item_name');
            $table->integer('qty');
            $table->integer('cost');
            $table->string('note')->nullable();
        });

        Schema::create('cparents', function (Blueprint $table) {
            $table->id();
            $table->string('nik')->nullable();
            $table->string('name');
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('emergency_name')->nullable();
            $table->string('emergency_phone')->nullable();
            $table->string('bank_account_name')->nullable();
            $table->string('virtual_account_name')->nullable();
            $table->string('note')->nullable();
            $table->integer('user_id')->nullable();
            $table->string('blacklist')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->integer('cparent_id')->nullable();
            $table->integer('school_id')->nullable();
            $table->string('grade')->nullable();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->date('join_date')->nullable();
            $table->date('exit_date')->nullable();
            $table->string('exit_reason')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('type')->nullable();
            $table->string('health_condition')->nullable();
            $table->string('note')->nullable();
            $table->integer('user_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('schools', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('type')->nullable();
            $table->string('color_code')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('pricelists', function (Blueprint $table) {
            $table->id();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('level')->nullable();
            $table->string('school_type')->nullable();
            $table->string('subject')->nullable();
            $table->integer('price')->nullable();
            $table->string('week')->nullable();
            $table->integer('branch_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('promolists', function (Blueprint $table) {
            $table->id();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('label');
            $table->string('discount_value')->nullable();
            $table->integer('branch_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->integer('student_id')->nullable();
            $table->integer('branch_id')->nullable();
            $table->date('date')->nullable();
            $table->string('reference')->nullable();
            $table->string('cashback')->nullable();
            $table->string('status')->nullable();
            $table->string('note')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('registration_items', function (Blueprint $table) {
            $table->id();
            $table->integer('registration_id')->nullable();
            $table->integer('pricelist_id')->nullable();
            $table->integer('promolist_id')->nullable();
            $table->string('charges')->nullable();
            $table->integer('price')->nullable();
            $table->string('discount_amount')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });


        Schema::create('salaries', function (Blueprint $table) {
            $table->id();
            $table->integer('employee_id')->nullable();
            $table->integer('amount')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('note')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });


        /*
        Schema::create('advisors', function (Blueprint $table) {
            $table->id();
            $table->integer('employee_id');
            $table->string('note');
            
            $table->timestamps();
$table->softDeletes();
        });


        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->integer('employee_id');
            $table->string('subject');
            $table->string('note');
            
            $table->timestamps();
$table->softDeletes();
        });


        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            $table->integer('teacher_id');
            $table->string('subject');
            $table->string('school');
            
            $table->timestamps();
$table->softDeletes();
        });


        Schema::create('histories', function (Blueprint $table) {
            $table->id();
            $table->string('model');
            $table->integer('model_id');
            $table->string('action');
            $table->string('changes');
            $table->string('note');
            
            $table->timestamps();
$table->softDeletes();
        });

        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->date('day');
            $table->string('time_slot');
            $table->string('subject');
            $table->string('classroom');
            $table->string('duration');
            $table->date('date');
            
            $table->timestamps();
$table->softDeletes();
        });
        */
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
