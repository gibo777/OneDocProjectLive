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
        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->string('department_code', 12);
            $table->string('department');
            $table->boolean('is_deleted')->nullable();
            $table->string('deleted_by',12)->nullable();
            $table->timestamp('date_deleted')->nullable();
            $table->string('created_by',12)->nullable();
            $table->string('updated_by',12)->nullable();
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
        Schema::dropIfExists('departments');
    }
};
