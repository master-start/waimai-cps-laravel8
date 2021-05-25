<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('banner')->insert([
            'img' => 'https://lanchong.oss.94mmp.cn/douzuanshe/admin/1610109525.jpeg',
            'add_time' => time(),
            'index' => 0,
        ]);
        DB::table('banner')->insert(
            [
                'img' => 'https://lanchong.oss.94mmp.cn/douzuanshe/admin/1610538895.jpg',
                'add_time' => time(),
                'index' => 1,
            ]);

   }
}
