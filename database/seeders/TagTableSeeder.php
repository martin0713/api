<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TagTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tags = [];
        for ($i = 1; $i < 4; $i++) {
            $tag = [];
            $tag['id'] = $i;
            $tag['name'] = 'tag:' . $i;
            $tag['created_at'] = date('Y-m-d H:i:s');
            $tag['updated_at'] = date('Y-m-d H:i:s');
            $tags[] = $tag;
        }
        DB::table('tags')->insert($tags);
    }
}
