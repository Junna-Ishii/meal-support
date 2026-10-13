<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Post;
use App\Models\Evaluation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        // ==================================================
        // Seeder用画像をstorage/app/public/postsへコピー
        // ==================================================

        $seedImagePath = database_path('seed_images/posts');
        $storageImagePath = storage_path('app/public/posts');


        // storage/app/public/posts がなければ作成
        if (!File::exists($storageImagePath)) {
            File::makeDirectory($storageImagePath, 0755, true);
        }


        // 既存のSeeder画像を削除
        // ※新しく投稿した画像などはここで一度消える
        // ※元画像はdatabase/seed_images/postsに残っているので問題なし
        File::cleanDirectory($storageImagePath);


        // Seeder用画像をコピー
        $seedImages = [
            '納豆朝食.png',
            '昼食の外食.jpg',
            '焼肉屋さんでの夕食.jpg',
            'シリアル朝食.jpg',
        ];


        foreach ($seedImages as $image) {

            $source = $seedImagePath . '/' . $image;
            $destination = $storageImagePath . '/' . $image;

            if (File::exists($source)) {
                File::copy($source, $destination);
            }
        }


        // ==================================================
        // 栄養士アカウント
        // ==================================================

        $nutritionist = User::create([
            'name' => '山田太郎',
            'email' => 'nutritionist@example.com',
            'password' => Hash::make('password'),

            'introduction' => '病院にて10年間の栄養指導経験があります。皆さんの日々の食生活を、ストレスなく少しずつ改善するサポートをします。一緒に頑張りましょう。',

            'role_id' => 1,
        ]);


        // ==================================================
        // 一般ユーザーアカウント
        // ==================================================

        $user = User::create([
            'name' => '田中花子',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),

            'introduction' => '毎日の食事を記録し、健康維持を目指しています。ダイエットもできたらしたいです。',

            'role_id' => 2,
        ]);


        // ==================================================
        // カテゴリー
        // ==================================================

        $breakfast = Category::create([
            'name' => '朝食',
        ]);

        $lunch = Category::create([
            'name' => '昼食',
        ]);

        $dinner = Category::create([
            'name' => '夕食',
        ]);

        $snack = Category::create([
            'name' => '間食',
        ]);


        // ==================================================
        // 投稿①【朝食】
        // 納豆朝食.png
        // 評価済み
        // ==================================================

        $post1 = Post::create([

            // storage/app/public/posts/納豆朝食.png
            'image' => 'posts/納豆朝食.png',

            'user_id' => $user->id,

            'meal_content' => 'ご飯、具沢山味噌汁、納豆、糠漬け',

            'comment' => '昨日の残り物を活用して頑張りました！',
        ]);


        // 投稿① → 朝食
        DB::table('category_post')->insert([
            'category_id' => $breakfast->id,
            'post_id' => $post1->id,
        ]);


        // ==================================================
        // 投稿②【昼食】
        // 昼食の外食.jpg
        // 評価済み
        // ==================================================

        $post2 = Post::create([

            // storage/app/public/posts/昼食の外食.jpg
            'image' => 'posts/昼食の外食.jpg',

            'user_id' => $user->id,

            'meal_content' => 'カルボナーラ、野菜サラダ',

            'comment' => '外食ですがサラダをセットにつけました。',
        ]);


        // 投稿② → 昼食
        DB::table('category_post')->insert([
            'category_id' => $lunch->id,
            'post_id' => $post2->id,
        ]);


        // ==================================================
        // 投稿③【夕食】
        // 焼肉屋さんでの夕食.jpg
        // 評価済み
        // ==================================================

        $post3 = Post::create([

            // storage/app/public/posts/焼肉屋さんでの夕食.jpg
            'image' => 'posts/焼肉屋さんでの夕食.jpg',

            'user_id' => $user->id,

            'meal_content' => '焼肉、ナムル、お酒など、、、食べ放題でした。',

            'comment' => '昼夜ともに外食でした。お腹いっぱい食べてから後悔することが多いです、、。何か食べ放題でのコツはありますか？',
        ]);


        // 投稿③ → 夕食
        DB::table('category_post')->insert([
            'category_id' => $dinner->id,
            'post_id' => $post3->id,
        ]);


        // ==================================================
        // 投稿④【朝食】
        // シリアル朝食.jpg
        // 未評価
        // ==================================================

        $post4 = Post::create([

            // storage/app/public/posts/シリアル朝食.jpg
            'image' => 'posts/シリアル朝食.jpg',

            'user_id' => $user->id,

            'meal_content' => 'フルーツグラノーラ、牛乳',

            'comment' => '時間がないのでささっと食べました。',
        ]);


        // 投稿④ → 朝食
        DB::table('category_post')->insert([
            'category_id' => $breakfast->id,
            'post_id' => $post4->id,
        ]);


        // ==================================================
        // 投稿① → 栄養士が評価
        // ==================================================

        Evaluation::create([
            'post_id' => $post1->id,
            'nutritionist_id' => $nutritionist->id,

            'rating' => 5,

            'comment' => 'とてもバランスの良い朝食ですね！朝食は一日の中でも体を動かすエネルギーを作り出すため、要となります。これからもぜひ継続してください。',
        ]);


        // ==================================================
        // 投稿② → 栄養士が評価
        // ==================================================

        Evaluation::create([
            'post_id' => $post2->id,
            'nutritionist_id' => $nutritionist->id,

            'rating' => 5,

            'comment' => '意識的にサラダを追加できていて、とても良いですね。夕食は少し油を控えた料理がおすすめです。又、一日の中で果物を取り入れると食物繊維やミネラル・ビタミンの補給ができるのでおすすめです。',
        ]);


        // ==================================================
        // 投稿③ → 栄養士が評価
        // ==================================================

        Evaluation::create([
            'post_id' => $post3->id,
            'nutritionist_id' => $nutritionist->id,

            'rating' => 3,

            'comment' => '焼肉の食べ放題、ついつい食べ過ぎてしまいますよね,,,。ポイントとしては、まず生野菜を先に注文して、空腹感を和らげることです。また、焼肉を食べている途中はサンチュやナムルなどを積極的に摂るのもおすすめです。塩分がどうしても過剰になってしまうので、下味がついているお肉はレモン汁だけで食べることや、スープやキムチなどはなるべく避けるなど、ご自身の負担にならない所から注意していければ良いと思います。今日も一日お疲れ様でした。',
        ]);


        // ==================================================
        // 投稿④ → 未評価
        // ==================================================
        //
        // あえて Evaluation::create() を書かない。
        // そのため、投稿④は「未評価」として表示される。
        // ==================================================
    }
}