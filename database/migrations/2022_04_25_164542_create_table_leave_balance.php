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
        Schema::create('leave_balances', function (Blueprint $table) {
            $table->id();
            $table->integer('employee_id');
            $table->integer('VL')->nullable();
            $table->integer('SL')->nullable();
            $table->integer('ML')->nullable();
            $table->integer('PL')->nullable();
            $table->integer('EL')->nullable();
            $table->integer('Others')->nullable();
            $table->datetime('updated_date');
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
        Schema::dropIfExists('leave_balances');
    }
};
