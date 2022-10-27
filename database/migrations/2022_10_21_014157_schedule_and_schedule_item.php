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

        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->string('class_subject')->nullable();
            $table->string('class_room')->nullable();
            $table->integer('teacher_id')->nullable();
            $table->integer('branch_id')->nullable();
            $table->string('students')->nullable();
            $table->integer('week')->nullable();
        });

        Schema::create('schedule_items', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->integer('schedule_id')->nullable();
            $table->date('session_date', $precision = 0);
            $table->time('session_start_time', $precision = 0);
            $table->time('session_end_time', $precision = 0);
        });

        /*
        Schema::create('attendance', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();

            $table->integer('schedule_item_id')->nullable();
            $table->dateTime('start_at', $precision = 0);
            $table->dateTime('end_at', $precision = 0);
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
