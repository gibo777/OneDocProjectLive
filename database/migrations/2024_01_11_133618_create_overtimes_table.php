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
        Schema::create('overtimes', function (Blueprint $table) {
            $table->id('id');
            $table->bigInteger('ref_id')->nullable();
            $table->string('name', 150);
            $table->string('employee_id', 12);
            $table->string('ot_control_number', 50)->nullable();
            $table->string('ot_location', 150)->nullable();
            $table->string('ot_reason', 150)->nullable();
            $table->date('ot_date_from')->nullable();
            $table->date('ot_date_to')->nullable();
            $table->time('ot_time_from')->nullable();
            $table->time('ot_time_to')->nullable();
            $table->integer('ot_hours')->nullable();
            $table->integer('ot_minutes')->nullable();
            $table->decimal('ot_hrmins', 4, 2);
            $table->string('ot_status', 25)->default('pending');
            $table->integer('office')->nullable();
            $table->string('department', 12)->nullable();
            $table->string('head_id', 12)->nullable();
            $table->string('head_name', 150)->nullable();
            $table->boolean('is_head_approved')->default(0);
            $table->datetime('head_approved_at')->nullable();
            $table->boolean('is_cancelled')->default(0);
            $table->datetime('cancelled_at')->nullable();
            $table->string('cancelled_by', 12)->nullable();
            $table->boolean('is_denied')->default(0);
            $table->datetime('denied_at')->nullable();
            $table->datetime('denied_reason')->nullable();
            $table->string('denied_by', 12)->nullable();
            $table->integer('rcdversion')->default(0);
            $table->timestamps();
            $table->string('created_by', 12)->nullable();
            $table->string('updated_by', 12)->nullable();
        });

        // Create triggers
        $this->createTriggers();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Drop triggers
        $this->dropTriggers();

        Schema::dropIfExists('overtimes');
    }

    /**
     * Create triggers for the 'overtimes' table.
     *
     * @return void
     */
    private function createTriggers()
    {
        Schema::create('audit_trail_overtimes', function (Blueprint $table) {
            $table->id('id');
            $table->string('at_trigger_action', 10)->nullable();
            $table->datetime('at_trigger_date')->nullable();
            $table->bigInteger('ref_id')->nullable();
            $table->string('name', 150);
            $table->string('employee_id', 12);
            $table->string('ot_control_number', 50)->nullable();
            $table->string('ot_location', 150)->nullable();
            $table->string('ot_reason', 150)->nullable();
            $table->date('ot_date_from')->nullable();
            $table->date('ot_date_to')->nullable();
            $table->time('ot_time_from')->nullable();
            $table->time('ot_time_to')->nullable();
            $table->integer('ot_hours')->nullable();
            $table->integer('ot_minutes')->nullable();
            $table->decimal('ot_hrmins', 4, 2);
            $table->string('ot_status', 25)->default('pending');
            $table->integer('office')->nullable();
            $table->string('department', 12)->nullable();
            $table->string('head_id', 12)->nullable();
            $table->string('head_name', 150)->nullable();
            $table->boolean('is_head_approved')->default(0);
            $table->datetime('head_approved_at')->nullable();
            $table->boolean('is_cancelled')->default(0);
            $table->datetime('cancelled_at')->nullable();
            $table->string('cancelled_by', 12)->nullable();
            $table->boolean('is_denied')->default(0);
            $table->datetime('denied_at')->nullable();
            $table->datetime('denied_reason')->nullable();
            $table->string('denied_by', 12)->nullable();
            $table->integer('rcdversion')->default(0);
            $table->timestamps();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
        });

        DB::unprepared('
            CREATE TRIGGER your_trigger_name
            BEFORE INSERT ON overtimes
            FOR EACH ROW
            BEGIN
                -- Your trigger logic here
            END
        ');

        // Add more triggers if needed
    }

    /**
     * Drop triggers for the 'overtimes' table.
     *
     * @return void
     */
    private function dropTriggers()
    {
        DB::unprepared('DROP TRIGGER IF EXISTS your_trigger_name');

        // Drop more triggers if needed
    }
};
