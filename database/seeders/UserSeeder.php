<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'superadmin',
            'email' => 'superadmin@8dmasptool.com',
            'password' => bcrypt('@Super@adm!n'),
            'profile' => 'superadmin',
            'status' => 1
        ]);
    }
}
