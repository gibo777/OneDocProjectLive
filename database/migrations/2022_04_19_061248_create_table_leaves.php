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
        Schema::create('leaves', function (Blueprint $table) {
            $table->id();
            $table->integer('leave_number')->nullable();
            $table->string('name');
            $table->integer('department');
            $table->timestamp('date_applied')->nullable();
            $table->string('employee_id',12);
            $table->string('leave_type');
            $table->string('others')->nullable();
            $table->string('reason');
            $table->string('notification');
            $table->date('date_from')->nullable(); 
            $table->date('date_to')->nullable();
            $table->integer('no_of_days')->nullable();
            $table->boolean('is_head_approved')->nullable();
            $table->timestamp('date_approved_head')->nullable();
            $table->string('head_name')->nullable();
            $table->boolean('is_hr_approved')->nullable();
            $table->timestamp('date_approved_hr')->nullable();
            $table->boolean('is_denied')->nullable();
            $table->timestamp('date_denied')->nullable();
            $table->string('denied_by',12)->nullable();
            $table->boolean('is_cancelled')->nullable();
            $table->timestamp('date_cancelled')->nullable();
            $table->string('cancelled_by',12)->nullable();
            $table->boolean('is_taken')->nullable();
            $table->timestamp('date_taken')->nullable();
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
        Schema::dropIfExists('leaves');
    }
};
