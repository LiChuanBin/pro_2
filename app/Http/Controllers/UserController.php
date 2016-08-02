<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hash;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class UserController extends Controller
{ 
    //用户的添加页面
    public function getAdd()
    {
    	return view('admin.user.add');
    }

    //用户的插入操作
    public function postInsert(Request $request)
    {	
    	//表单验证
    	$this->validate($request,[
    		'username' => 'required|regex:/^\w{6,18}/|unique:users',
    		'password' => 'required|regex:/^\S{6,18}$/|same:repassword',
    		'email' => 'required|email',
    		'phone' => 'required|regex:/^1\d{10}$/'
    		],[
    		'username.required' => '用户名不能为空',
    		'username.regex' => '用户名格式不正确',
    		'username.unique' => '用户名已存在',
    		'password.required' => '密码不能为空',
    		'password.regex' => '密码格式不正确',
    		'password.same' => '两次密码不一致',
    		'email.required' => '邮箱账号不能为空',
    		'email.email' => '邮箱账号格式不正确',
    		'phone.required' => '手机号不能为空',
    		'phone.regex' => '手机号格式不正确'
    		]);
    	//获取参数
    	$data = $request->except(['_token','repassword','profile']);
    	//添加字段内容
    	$data['status'] = 1;
    	//密码加密
    	$data['password'] = Hash::make($data['password']);
    	//文件上产
    	if($request->hasFile('profile')){
    		//获取随机名
    		$name = time().rand(1000000,9999999);
    		//获取后缀
    		$suffix = $request->file('profile')->getClientOriginalExtension();
   			$dir = config('app.upload_dir');
    		//移动文件
    		$request->file('profile')->move($dir,$name.'.'.$suffix);
    		//拼接路径
    		$data['profile'] = trim($dir,'.').$name.'.'.$suffix;
    	}
    	// var_dump($data);die;
    	//将数据插入到数据表中
    	if(DB::table('users')->insert($data)){
    		return redirect('/user/index')->with('info','添加成功');
    	}else{
    		return back('/user/add')->with('info','插入失败');
    	}
    }
    //用户的显示页面
    public function getIndex(Request $request)
    {
        // dd($request->all());
    	//读取用户数句
        $users = DB::table('users')
            ->orderBy('id','desc')
            ->where(function($query)use($request){
                //判断当前的关键字元素
                $keyword = $request->input('keyword');
                if(!empty($keyword)){
                    $query->where('username','like','%'.$keyword.'%');
                }
            })
            ->paginate($request->input('num',10));
        
        //解析模板并分配变量
        return view('admin.user.index',[
            'users' => $users,
            'request' => $request
            ]);
    }

    public function getAupdate(Request $request)
    {
        //获取参数
        $data = $request->only(['status']);
        //更新
        $res = DB::table('users')
            ->where('id','=',$request->input('id'))
            ->update($data);
        if($res){
            echo 1;die;
        }else{
            echo 0;die;
        }
    }

    /**
     * 用户的修改页面显是
     */
    public function getEdit(Request $request)
    {
        //读取用户信息
        $info = DB::table('users')->where('id','=',$request->input('id'))->first();
        //分配变量
        return view('admin.user.edit',[
            'info' => $info
            ]);
    }

    /**
     * 用户的更新操作
     */
    public function postUpdate(Request $request)
    {
        //表单验证
        $this->validate($request,[
            'username' => 'required|regex:/^\w{6,18}/|unique:users',
            'email' => 'required|email',
            'phone' => 'required|regex:/^1\d{10}$/'
            ],[
            'username.required' => '用户名不能为空',
            'username.regex' => '用户名格式不正确',
            'username.unique' => '用户名已存在',
            'email.required' => '邮箱账号不能为空',
            'email.email' => '邮箱账号格式不正确',
            'phone.required' => '手机号不能为空',
            'phone.regex' => '手机号格式不正确'
            ]);
        //获取参数
       $data = $request->except(['_token','id','profile']);
       //图片上传
       if($request->hasFile('profile')){
            //移动文件
            $name = time().rand(1000000,9999999);
            //获取后缀
            $suffix = $request->file('profile')->getClientOriginalExtension();
            $dir = config('app.upload_dir');
            $request->file('profile')->move($dir,$name.'.'.$suffix);
            //拼接图片的路径
            $data['profile'] = trim($dir,'.').$name.'.'.$suffix;
       }
       //开始更新
       $res = DB::table('users')->where('id','=',$request->input('id'))->update($data);
       //判断
       if($res){
            return redirect('/user/index')->with('info','更新成功');
       }else{
            return back()->with('info','更新失败');
       }
    }

    /**
     * 用户的删除操作
     */
    public function getDelete(Request $request)
    {
        //获取id参数
        $id = $request->input('id');
        //获取用户信息
        $info = DB::table('users')->where('id','=',$id)->first();
        //获取图片路径
        $path = $info->profile;
        //删除图片
        @unlink('.'.$path);
        //删除
        $res = DB::table('users')->where('id','=',$id)->delete();
        if($res){
            return back()->with('info','删除成功');
        }else{
            return back()->with('info','删除失败');
        }
    }
}


