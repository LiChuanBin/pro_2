<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //创建数据并插入到数据库中
    	$data = [];
    	for($i=0;$i<10;$i++){
    		//声明一个空数组
    		$temp = [];
    		$temp['username'] = str_random(10);
    		$temp['password'] = Hash::make('iloveyou');
    		$temp['email'] = str_random(6).'@163.com';
    		$temp['phone'] = '1'.rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9);
    		$temp['profile'] = '/upload/14696384728837646.jpg';
    		$temp['status'] = 1;
    		$data[] = $temp;
    	}
    	DB::table('users')->insert($data);
    }
}
