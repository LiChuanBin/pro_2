<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Config;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class GoodsController extends Controller
{
    /**
     * 商品的添加操作
     */
    public function getAdd()
    {	
    	//获取分类信息
    	$cates = CateController::getAllCates2();
    	
    	//解析模板
    	return view('admin.goods.add',[
    		'cates' => $cates
    		]);
    }

    /**
     * 商品的插入操作
     */
    public function postInsert(Request $request)
    {
    	//获取参数
    	$data = $request->except(['_token','path']);
    	//将数据插入到数据库
    	$gid = DB::table('goods')->insertGetId($data);
    	//判断
    	if(!$gid){
    		return back()->with('info','插入失败');
    	}
    	//针对多文件上传
    	if($request->hasFile('path')){
    		$data = [];
    		foreach ($request->file('path') as $key => $value) {
    			$temp = [];
    			$temp['goods_id'] = $gid;
    			//定义文件夹的位置
    			$dir = Config::get('app.upload_dir');
    			$name = time().rand(100000,999999);
    			$suffix = $value->getClientOriginalExtension();
    			$value->move($dir,$name.'.'.$suffix);
    			$temp['path'] = trim($dir.$name.'.'.$suffix,'.');
    			//降临时数组压入到数组中
    			$data[] = $temp;
    		}
    		//将图片信息插入到图片表表
    		$res = DB::table('goods_images')->insert($data);
    		if($res){
    			return redirect('/goods/index')->with('info','插入成功');
    		}else{
    			return back()->with('info','插入失败');
    		}
    		return redirect()->with('info','插入成功');
    	}
    }

    /**
     * 商品的列表显示页面
     */
    public function getIndex(Request $request)
    {
    	//读取数据
    	$res = DB::table('goods')
    		->orderBy('id','desc')
    		->where(function($query)use($request){
    			if($request->input('keyword')){
    				$query->where('title','like','%'.$request->input('keyword').'%');
    			}
    		})
    		->paginate($request->input('num',10));
    	//解析模板
    	return view('admin.goods.index',[
    		'request' => $request,
    		'goods' => $res
    		]);
    }

    /**
     * 异步更新
     */
    public function postAupdate(Request $request)
    {
    	//获取参数
    	$data = $request->only(['status']);
    	//更新
    	$res = DB::table('goods')->where('id','=',$request->input('id'))->update($data);
    	if($res){
    		echo 1;die;
    	}else{
    		echo 0;die;
    	}
    }

    /**
     * 商品修改操作
     */
    public function getEdit(Request $request)
    {
    	//获取分类信息
    	$cates = CateController::getAllCates2();
    	//获取id
    	$id = $request->input('id');
    	//读取信息
    	$info = DB::table('goods')->where('id','=',$id)->first();
    	//读取当前商品下的图片的信息
    	$images = DB::table('goods_images')->where('goods_id','=',$id)->get();
    	//解析模板
    	return view('admin.goods.edit',[
    		'info' => $info,
    		'cates' => $cates,
    		'iamges' => $images
    		]);
    }
}
