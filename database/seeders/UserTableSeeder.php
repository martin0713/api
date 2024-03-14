<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [];
        for ($i = 1; $i < 4; $i++) {
            $user = [];
            $user['id'] = $i;
            $user['name'] = 'user' . $i;
            $user['email'] = "user$i@example.com";
            $user['password'] = bcrypt('<PASSWORD>');
            $user['created_at'] = date('Y-m-d H:i:s');
            $user['updated_at'] = date('Y-m-d H:i:s');
            $users[] = $user;
        }
        DB::table('users')->insert($users);
    }
}
