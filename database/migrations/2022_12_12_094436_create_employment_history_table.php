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
        Schema::create('employment_history', function (Blueprint $table) {
            $table->id();
            $table->string('employee_id',12);
            $table->string('employer_name',100);
            $table->string('business_nature',100);
            $table->string('position',100)->nullable();

            $table->date('date_from')->nullable();
            $table->date('date_to')->nullable();

            $table->boolean('is_deleted')->nullable();
            $table->string('deleted_by')->nullable();
            $table->date('deleted_at')->nullable();

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
        Schema::dropIfExists('employment_history');
    }
};
