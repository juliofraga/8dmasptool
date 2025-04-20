<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersHasAreaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_has_area', function (Blueprint $table) {
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('area_id');
            $table->boolean('manager')->default(0)->comment('0 - No\n1 - Yes');

            $table->primary(['user_id', 'area_id']);
            $table->index('area_id', 'fk_usuarios_has_area_area1_idx');
            $table->index('user_id', 'fk_usuarios_has_area_usuarios_idx');

            $table->foreign('user_id', 'fk_usuarios_has_area_usuarios')
                ->references('id')
                ->on('users')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('area_id', 'fk_usuarios_has_area_area1')
                ->references('id')
                ->on('areas')
                ->onDelete('no action')
                ->onUpdate('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users_has_area');
    }
}