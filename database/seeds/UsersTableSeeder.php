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
            'role' => 'admin',
            'created_at' => now()
        ]);

//        factory(App\User::class, 100)->create()->each(function($user){
//            if ($user->role === "employer"){
//                factory(App\Company::class)->create();
//            }
//        });

        factory(App\User::class, 50)->create(['role' => 'employer'])->each(function($user){
            factory(App\Organization::class, rand (1, 4))->create(['user_id' => $user->id])->each(function($organization){
                factory(App\Vacancy::class, rand(0,2))->create(['organization_id' => $organization->id]);
            });
        });

        factory(App\User::class, 50)->create(['role' => 'worker']);

    }
}
