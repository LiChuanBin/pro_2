<?php

use Illuminate\Database\Seeder;

class Goods extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $data = [];
        for ($i=0; $i < 30; $i++) { 
        	$temp = [];
        	$temp['title'] = str_random(10);
        	$temp['price'] = rand(100,1000);
        	$temp['content'] = str_random(200);
        	$temp['cate_id'] = rand(2,11);
        	$temp['color'] = '白色,黑色,红色,灰色';
        	$temp['size'] = '40,41,42,43,44';	
        	$temp['status'] = '1';
        	$data[] = $temp;
        }
        DB::table('goods')->insert($data);
    }
}
