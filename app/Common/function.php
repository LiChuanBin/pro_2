<?php

	/**
	 * 通过分类id获取分类名称
	 */
	function getCateNameById($id)
	{
		//判断
		if($id == '0'){
			return '顶级分类';
		}

		//读取数据库
		$info = DB::table('cates')->where('id','=',$id)->first();
		//返回名称
		return $info->name;
	}
	
?>