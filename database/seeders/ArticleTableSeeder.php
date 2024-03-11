<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ArticleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $articles = array();
        for ($i = 1; $i <= 10; $i++) {
            $article = array();
            $article['id'] = $i;
            $article['title'] = 'article' . $i;
            $article['body'] = uniqid();
            $article['records'] = json_encode(array('time' => 1));
            $article['user_id'] = rand(1,3);
            $article['image'] = uniqid();
            $article['created_at'] = date('Y-m-d H:i:s');
            $article['updated_at'] = date('Y-m-d H:i:s');
            array_push($articles, $article);
        }
        DB::table('articles')->insert($articles);
    }
}
