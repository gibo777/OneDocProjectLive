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
        Schema::create('leave_history', function (Blueprint $table) {
            $table->id();
            $table->integer('leave_reference')->nullable();
            $table->integer('leave_number')->nullable();
            $table->string('action')->nullable();
            $table->string('reason')->nullable();
            $table->string('name');
            $table->integer('department');
            $table->timestamp('date_applied')->nullable();
            $table->string('employee_id',12);
            $table->string('leave_type');
            $table->string('others')->nullable();
            $table->string('leave_reason');
            $table->string('notification');
            $table->date('date_from')->nullable(); 
            $table->date('date_to')->nullable();
            $table->integer('no_of_days')->nullable();
            $table->boolean('is_head_approved')->nullable();
            $table->timestamp('date_approved_head')->nullable();
            $table->string('head_name')->nullable();
            $table->boolean('is_hr_approved')->nullable();
            $table->timestamp('date_approved_hr')->nullable();
            $table->string('hr_name')->nullable();
            $table->boolean('is_deleted')->nullable();
            $table->string('deleted_by',12)->nullable();
            $table->timestamp('date_deleted')->nullable();
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
        Schema::dropIfExists('leave_history');
    }
};
