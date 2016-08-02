<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class UsersController extends Controller
{
    //用户添加操作
   public function getAdd()
   {
   		return view('admins.users.add');
   }

 	//用户插入操作
   public function postInsert(Request $request)
   {
   		// var_dump($request->all());
   		//表单验证
   		$this->validate($request,[
   			'username' => 'required|regex:/^\w{6,18}$/',
   			'password' => 'required|regex:/^\d{6,20}$/|same:repassword',
   			'email' => 'required|email',
   			'phone' => 'required|regex:/^1\d{10}$/'
   			],[
   			'username.required' => '用户名不能为空',
   			// 'username.unique' => '用户名已存在',
   			'username.regex' => '用户名格式不正确',
   			'password.required' => '密码不能为空',
   			'password.regex' => '密码格式不正确',
   			'password.same' => '两次密码不一致',
   			'email.required' => '邮箱账号不能为空',
   			'email.email' => '邮箱账号格式不正确',
   			'phone.required' => '手机号不能为空',
   			'phone.regex' => '手机号格式不正确',
   			]);
   		//获取参数
   		$data = $request->except('_token','repassword','profile');
   		//添加参数
   		$data['status'] = 1;
   		//密码加密
   		$data['password'] = Hash::make($data['password']);
   		//将数据插入到数据库
   		DB::table('users')->insert($data);
   }
   //用户的显示页面
   public function getIndex()
   {
   		echo '这里是用户的显示页面..';
   }
}
