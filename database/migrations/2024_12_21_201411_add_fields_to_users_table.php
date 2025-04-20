<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('profile', 20)->comment('Options: superadmin, administrator, manager, user	');
            $table->tinyInteger('status')->default(1)->comment('1 - Active 0 - Inactive 2 - Blocked');
            $table->dateTime('first_login')->nullable();
            $table->dateTime('last_login')->nullable();
            $table->integer('login_error')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'profile',
                'status',
                'first_login',
                'last_login',
                'login_error',
            ]);
        });
    }
}
