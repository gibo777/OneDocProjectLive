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
        Schema::create('family_background', function (Blueprint $table) {
            $table->id();
            $table->string('employee_id',12);
            $table->string('fb_name');
            $table->date('fb_birthdate');
            $table->string('fb_relationship',100);

            $table->string('fb_address');
            $table->string('fb_contact',50);

            $table->string('fb_occupation')->nullable();
            $table->string('fb_company_name')->nullable();
            $table->string('fb_company_address')->nullable();
            $table->string('fb_company_contact')->nullable();

            $table->boolean('is_tax_dependent')->nullable();
            $table->boolean('is_sss_beneficiary')->nullable();
            $table->boolean('is_phic_beneficiary')->nullable();
            $table->boolean('can_be_notified')->nullable();

            $table->boolean('is_deleted')->nullable();
            $table->date('deleted_at')->nullable();
            $table->string('deleted_by');

            $table->string('created_by');
            $table->string('updated_by');
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
        Schema::dropIfExists('family_background');
    }
};
