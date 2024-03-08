<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tag;

class TagTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 1; $i <4; $i++) {
            $tag = new Tag;
            $tag->name = 'tag:'.$i;
            $tag->save();
        }
    }
}
