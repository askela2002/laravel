<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'email' => 'admin@localhost',
            'password' => bcrypt('123456'),
            'role' => 'admin'
        ]);

        $users = factory(App\User::class, 100)->create();
    }
}
