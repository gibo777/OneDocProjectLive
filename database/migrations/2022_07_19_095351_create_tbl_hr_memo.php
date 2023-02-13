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
        Schema::create('hr_memo', function (Blueprint $table) {
            $table->id();
            $table->string('memo_send_option',12);
            $table->string('file_name',255);
            $table->string('file_type',12)->nullable();
            // $table->integer('file_size',12)->unsigned()->nullable();
            $table->string('memo_subject',255);
            $table->string('uploaded_by',12);
            $table->timestamp('uploaded_at');
            $table->boolean('is_deleted')->nullable();
            $table->string('deleted_by',12)->nullable();
            $table->timestamp('deleted_at')->nullable();
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
        Schema::dropIfExists('hr_memo');
    }
};
