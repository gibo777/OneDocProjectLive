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
        Schema::create('leave_archive', function (Blueprint $table) {
            $table->id();
            $table->string('filename');
            $table->string('filepath');
            $table->string('type');
            $table->integer('size');
            $table->string('content');
            $table->timestamp('date_uploaded')->nullable();
            $table->integer('uploader_id');
            $table->timestamp('date_modified')->nullable();
            $table->integer('modifier_id');

        });
        DB::statement('ALTER TABLE leave_archive MODIFY COLUMN content LONGBLOB');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('leave_archive');
    }
};
