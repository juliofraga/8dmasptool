<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContainmentActionsTable extends Migration
{
    public function up()
    {
        Schema::create('containment_actions', function (Blueprint $table) {
            $table->id();
            $table->text('description');
            $table->dateTime('created_at');
            $table->dateTime('updated_at')->nullable();
            $table->unsignedBigInteger('incidents_id');
            $table->unsignedBigInteger('users_id');
            $table->primary(['id', 'incidents_id', 'users_id']);
            $table->index('incidents_id', 'fk_actions_incidents1_idx');
            $table->index('users_id', 'fk_containment_actions_users1_idx');

            $table->foreign('incidents_id', 'fk_actions_incidents1')
                ->references('id')->on('incidents')
                ->onUpdate('no action')->onDelete('no action');

            $table->foreign('users_id', 'fk_containment_actions_users1')
                ->references('id')->on('users')
                ->onUpdate('no action')->onDelete('no action');
        });
    }

    public function down()
    {
        Schema::dropIfExists('containment_actions');
    }
}