<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class CateController extends Controller
{
    /**
     * 分类的添加操作
     */
    public function getAdd()
    {
    	//获取分类信息
		$cates = $this->getAllCates();
    	//解析模板
    	return view('admin.cate.add',[
    		'cates'=>$cates,
    		]);
    }

    /**
     * 分类插入操作
     */
    public function postInsert(Request $request)
    {
    	// dd($request->all());die;
    	//获取元素
    	$data = $request->except(['_token']);
    	//判断是否是顶级分类
    	if($data['pid'] == '0'){
    		//获取path字段值
    		$data['path'] = '0';
    	}else{
    		//读取父级分类的信息
    		$info = DB::table('cates')->where('id','=',$data['pid'])->first();
    		//拼接当前分类的path字符串
    		$data['path'] = $info->path.','.$info->id;
    	}
    	//将数据插入到数据库
    	$res = DB::table('cates')->insert($data);
    	if($res){
    		return redirect('/cate/index');
    	}else{
    		return back();
    	}
	}

	/**
	 * 列表显示页面
	 */
	public function getIndex(Request $request)
	{
		// getCateNameById();
		//读取数据
		$cates = DB::table('cates')
			->select(DB::raw('*,concat(path,",",id) as paths'))
			->orderBy('paths')
			->orderBy('id')
			->where(function($query)use($request){
				$keyword = $request->input('keyword');
				if(!empty($keyword)){
					$query->where('name','like','%'.$keyword.'%');
				}
			})
			->paginate($request->input('num',10));
		$cates = $this->formatCateInfo($cates);
		
		//解析模板
		return view('admin.cate.index',[
			'cates' => $cates,
			'request' => $request
			]);	
	}

	/**
	 * ajax更新操作
	 */
	public function getAupdate(Request $request)
	{
		//获取参数
		$data = $request->only(['status']);
		//
		$res = DB::table('cates')->where('id','=',$request->input('id'))->update($data);
		//判断
		if($res){
			echo 1;die;
		}else{
			echo 0;die;
		}
	}

	/**
	 * 获取所有的分类信息
	 */
	private function getAllCates()
	{
		//将分类信息读出来
    	$cates = DB::table('cates')
			->select(DB::raw('*,concat(path,",",id) as paths'))
			->orderBy('paths')
			->get();

		//格式化显示的分类信息
		$cates = $this->formatCateInfo($cates);
		//返回结果
		return $cates;
	}

	/**
	 * 快速获取分类信息 
	 */
	public static function getAllCates2()
	{
		//将分类信息读出来
    	$cates = DB::table('cates')
			->select(DB::raw('*,concat(path,",",id) as paths'))
			->orderBy('paths')
			->get();

		//格式化显示的分类信息
		$cates = self::formatCateInfo2($cates);
		//返回结果
		return $cates;
	}

	/**
	 * 处理数据 格式化显示分类信息 
	 */
	public static function formatCateInfo2($cates)
	{
		foreach($cates as $k=>$v){
			//判断当前的分类分级
			$arr = explode(',',$v->path);
			$level = count($arr)-1;
			//修改分类的名称
			$v->name = str_repeat('&nbsp;&nbsp;',$level).$v->name;
		}
		//返回结果
		return $cates;
	}

	/**
	 * 处理数据 格式化显示分类信息 
	 */
	private function formatCateInfo($cates)
	{
		foreach($cates as $k=>$v){
			//判断当前的分类分级
			$arr = explode(',',$v->path);
			$level = count($arr)-1;
			//修改分类的名称
			$v->name = str_repeat('&nbsp;&nbsp;',$level).$v->name;
		}
		//返回结果
		return $cates;
	}

	/**
	 * 列表的修改操作
	 */
	public function getEdit(Request $request)
	{
		//获取id
		$id = $request->input('id');
		//读取当前分类信息
		$info = DB::table('cates')->where('id','=',$id)->first();
		//获取分类信息
		$cates = $this->getAllCates();
		//解析模板
		return view('admin.cate.edit',[
			'cates' => $cates,
			'info' => $info
			]);
	}

	/**
	 * 列表的更新操作
	 */
	public function postUpdate(Request $request)
	{
		//获取参数
		$data = $request->except(['_token','id']);
		//更新
		$res = DB::table('cates')->where('id','=',$request->input('id'))->update($data);
		//判断
		if($res){
			return redirect('/cate/index')->with('info','更新成功');
		}else{
			return back()->with('info','更新失败');
		}
	}

	/**
	 * 列表的删除操作
	 */
	public function getDelete(Request $request)
	{
		//获取要删除数据的id
		$id = $request->input('id');
		//读取分类信息
		$info = DB::table('cates')->where('id','=',$id)->first();
		//拼接路径开始的字符串
		$path = $info->path.','.$info->id;
		//先删除子分类
		DB::table('cates')->where('path','like',$path.'%')->delete();
		//删除当前分类的信息
		$res = DB::table('cates')->where('id','=',$id)->delete();
		//判断
		if($res){
			return back()->with('info','删除成功');
		}else{
			return back()->with('info','删除失败');
		}
	}

	//测试递归创建导航
	public function getTest()
	{
		$res = $this->getCateByDiGui(0);
		dd($res);
	}

	//递归方式获取分类信息
	public function getCateByDiGui($pid)
	{
		//获取分类
		$cates = DB::table('cates')->where('pid','=',$pid)->get();
		//遍历分类信息
		$sub_cate = [];
		foreach($cates as $k=>$v){
			$v->sub_cate = $this->getCateByDiGui($v->id);
			$sub_cate[] = $v;
		}
		return $sub_cate;
	}
}