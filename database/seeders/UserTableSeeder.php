<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 0; $i < 3 ; $i++) {
            $user = new User;
            $user->name = 'user'.$i;
            $user->email = "user$i@example.com";
            $user->password = bcrypt('<PASSWORD>');
            $user->save();
        }
    }
}
