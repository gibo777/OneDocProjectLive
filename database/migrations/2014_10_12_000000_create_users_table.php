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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('last_name');
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('suffix',15)->nullable();

            /*$table->string('suffix',15)->nullable();
            $table->string('suffix',15)->nullable();*/

            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->integer('access_code')->nullable();
            
            $table->string('department',12)->nullable();
            $table->string('employee_id',12)->nullable();
            $table->string('position',100)->nullable();
            $table->string('supervisor',12)->nullable();
            $table->string('weekly_schedule',50)->nullable();

            $table->date('date_hired')->nullable();
            $table->string('status',25)->nullable();
            $table->date('birthdate')->nullable();
            $table->rememberToken();
            $table->foreignId('current_team_id')->nullable();
            $table->string('profile_photo_path', 2048)->nullable();
            $table->boolean('is_deleted')->nullable();
            $table->string('deleted_by',12)->nullable();
            // $table->string('created_by',12)->nullable();
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
        Schema::dropIfExists('users');
    }
};
