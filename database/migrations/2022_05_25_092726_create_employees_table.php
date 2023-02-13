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
            $table->string('first_name');
            $table->string('last_name');
            $table->integer('department')->nullable();
            $table->string('employee_id',12)->nullable();
            $table->string('position')->nullable();
            $table->string('supervisor',12)->nullable();
            $table->date('date_hired')->nullable();
            $table->string('status')->nullable();
            $table->date('birthdate')->nullable();
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
        Schema::dropIfExists('employees');
    }
};
