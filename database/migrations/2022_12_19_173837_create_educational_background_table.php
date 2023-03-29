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
        Schema::create('educational_background', function (Blueprint $table) {
            $table->id();
            $table->string('employee_id',12);
            $table->string('school_type');
            $table->string('school_name');
            $table->date('date_inclusive_start')->nullable();
            $table->date('date_inclusive_end')->nullable();
            $table->string('course')->nullable();
            $table->date('date_graduated')->nullable();

            $table->boolean('is_deleted')->nullable();
            $table->date('deleted_at')->nullable();
            $table->string('deleted_by')->nullable();
            
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();

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
        Schema::dropIfExists('educational_background');
    }
};
