<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;

class ArticleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 1; $i <= 10; $i++){
            $article = new Article;
            $article->title = 'article'.$i;
            $article->body = uniqid();
            $article->records = array('time' => 1);
            $article->user_id = rand(1,3);
            $article->image = uniqid();
            $article->save();
        }
    }
}
