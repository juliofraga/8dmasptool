<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRootCausePotentialsTable extends Migration
{
    public function up()
    {
        Schema::create('root_cause_potentials', function (Blueprint $table) {
            $table->id();
            $table->text('description');
            $table->string('category', 45)->comment('method, machine, workforce, material, environment, measurement');
            $table->tinyInteger('is_root_cause')->default(0)->comment('0 - No 1 - Yes');
            $table->dateTime('created_at');
            $table->dateTime('updated_at');
            $table->unsignedBigInteger('incidents_id');

            $table->primary(['id', 'incidents_id']);
            $table->index('incidents_id', 'fk_analysis_incidents1_idx');

            $table->foreign('incidents_id', 'fk_analysis_incidents1')
                  ->references('id')->on('incidents')
                  ->onUpdate('no action')
                  ->onDelete('no action');
        });
    }

    public function down()
    {
        Schema::dropIfExists('root_cause_potentials');
    }
}
