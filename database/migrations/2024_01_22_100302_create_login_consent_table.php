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
        Schema::create('login_consent', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('ref_id')->unsigned()->nullable();
            $table->foreign('ref_id')->references('id')->on('users');
            $table->string('employee_id', 12);
            $table->string('email', 100)->nullable();
            $table->datetime('consent_date')->nullable();
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
        Schema::dropIfExists('login_consent');
    }
};
