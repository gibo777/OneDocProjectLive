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
        Schema::create('accounting_data', function (Blueprint $table) {
            $table->id();
            $table->string('employee_id',12)->nullable();
            $table->string('sss_number',10)->nullable();
            $table->string('phic_number',12)->nullable();
            $table->string('pagibig_number',12)->nullable();
            $table->string('access_code')->nullable();
            $table->string('tin_number',9)->nullable();
            $table->string('tax_status',25)->nullable();
            $table->string('health_card_number',25)->nullable();
            $table->string('drivers_license',12)->nullable();
            $table->string('passport_number',12)->nullable();
            $table->date('passport_expiry')->nullable();
            $table->string('prc',12)->nullable();
            $table->string('created_by',100)->nullable();
            $table->string('updated_by',100)->nullable();
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
        Schema::dropIfExists('accounting_data');
    }
};
