@extends('layout.admin')

@section('title','分类列表')

@section('content')
	<div class="mws-panel grid_8">
		<div class="mws-form-message error hide">
    	
	    </div>
	    <div class="mws-form-message success hide">
	        
	    </div>
        <div class="mws-panel grid_8">
		  <div class="mws-panel-header">
		    <span>
		      <i class="icon-th-list"></i>分类列表</span>
		  </div>
		  <div class="mws-panel-body no-padding">
		    <div role="grid" class="dataTables_wrapper" id="DataTables_Table_0_wrapper">
		      <form action="/cate/index" method="get">
		      		<div id="DataTables_Table_0_length" class="dataTables_length">
		        	<label>显示
		          <select name="num" size="1" aria-controls="DataTables_Table_0">
		            <option value="10" @if($request->input('num') == 10) selected="selected" @endif>10</option>
		            <option value="25" @if($request->input('num') == 25) selected="selected" @endif>25</option>
		            <option value="50" @if($request->input('num') == 50) selected="selected" @endif>50</option>
		            <option value="100" @if($request->input('num') == 100) selected="selected" @endif>100</option></select>条</label>
		      		</div>
		      		<div class="dataTables_filter" id="DataTables_Table_0_filter">
		       	 	<label>关键字
		            <input type="text" value="{{$request->input('keyword')}}" name="keyword" aria-controls="DataTables_Table_0"><button class="btn btn-primary">搜索</button></label>
		      	</form>
		      </div>
		      <table class="mws-datatable mws-table dataTable" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
		        <thead>
		          <tr role="row">
		            <th class="sorting_asc" role="columnheader" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 141px;" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending">ID</th>
		            <th class="sorting" role="columnheader" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 193px;" aria-label="Browser: activate to sort column ascending">分类名称</th>
		            <th class="sorting" role="columnheader" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 179px;" aria-label="Platform(s): activate to sort column ascending">父级分类名称</th>
		            <th class="sorting" role="columnheader" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 120px;" aria-label="Engine version: activate to sort column ascending">状态</th>
		            <th class="sorting" role="columnheader" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 86px;" aria-label="CSS grade: activate to sort column ascending">操作</th></tr>
		        </thead>
		        <tbody role="alert" aria-live="polite" aria-relevant="all">
		        	@foreach($cates as $k=>$v)
			          <tr class="@if($k%2==1) odd @else even @endif">
			            <td class=" ">{{$v->id}}</td>
			            <td class=" ">{{$v->name}}</td>
			            <td class=" ">{{getCateNameById($v->pid)}}</td>
			            <td class=" ">
			            	<input uid="{{$v->id}}" class="ibutton" type="checkbox" data-label-on="启用" data-label-off="禁用" @if($v->status == '1') checked="checked"  @endif>
			            </td>
			            <td class=" ">
			            	<a class="btn btn-info icon-pencil" href="/cate/edit?id={{$v->id}}"></a>
	            			<a class="btn btn-danger icon-trash" href="/cate/delete?id={{$v->id}}"></a>
			            </td>
			          </tr>
			        @endforeach
		        </tbody>
		      </table>
		    <!-- <div class="dataTables_paginate paging_full_numbers" id="DataTables_Table_1_paginate"> -->
			<div class="dataTables_paginate paging_full_numbers" id="DataTables_Table_1_paginate">
				<style type="text/css">
					#pages li{
						background-color: #444444;
					    border-left: 1px solid rgba(255, 255, 255, 0.15);
					    border-right: 1px solid rgba(0, 0, 0, 0.5);
					    box-shadow: 0 1px 0 rgba(0, 0, 0, 0.5), 0 1px 0 rgba(255, 255, 255, 0.15) inset;
					    color: #fff;
					    cursor: pointer;
					    display: block;
					    float: left;
					    font-size: 12px;
					    height: 20px;
					    line-height: 20px;
					    outline: medium none;
					    padding: 0 10px;
					    text-align: center;
					    text-decoration: none;
					}
					#pages li a{
						color:white;
					}
					#pages .active{
						background-color: #88a9eb;
					}
					#pages .active span{
						color:#323232;
					}
					#pages .disabled{
						background-color: #444444;
					    border-left: 1px solid rgba(255, 255, 255, 0.15);
					    border-right: 1px solid rgba(0, 0, 0, 0.5);
					    box-shadow: 0 1px 0 rgba(0, 0, 0, 0.5), 0 1px 0 rgba(255, 255, 255, 0.15) inset;
					    color: #fff;
					    cursor: pointer;
					    display: block;
					    float: left;
					    font-size: 12px;
					    height: 20px;
					    line-height: 20px;
					    outline: medium none;
					    padding: 0 10px;
					    text-align: center;
					    text-decoration: none;
					    color: #666666;
   						cursor: default;
					}
					#pages{
						height:auto;
						overflow:hidden;
						padding:0px;
						margin:0px;
					}
					#pages ul{
						padding-left:0px;
						margin:0px;
					}
				</style>
				<div id="pages">
					{!! $cates->appends($request->all())->render() !!}
				</div>
			  </div>
		    </div>
		  	</div>
		</div>
    </div>	
@endsection

@section('css')
	<link rel="stylesheet" type="text/css" href="/admins/plugins/colorpicker/colorpicker.css" media="screen">
	<link rel="stylesheet" type="text/css" href="/admins/custom-plugins/picklist/picklist.css" media="screen">
	<link rel="stylesheet" type="text/css" href="/admins/plugins/select2/select2.css" media="screen">
	<link rel="stylesheet" type="text/css" href="/admins/plugins/ibutton/jquery.ibutton.css" media="screen">
	<link rel="stylesheet" type="text/css" href="/admins/plugins/cleditor/jquery.cleditor.css" media="screen">

	<!-- Required Stylesheets -->
	<link rel="stylesheet" type="text/css" href="/admins/bootstrap/css/bootstrap.min.css" media="screen">
	<link rel="stylesheet" type="text/css" href="/admins/css/fonts/ptsans/stylesheet.css" media="screen">
	<link rel="stylesheet" type="text/css" href="/admins/css/fonts/icomoon/style.css" media="screen">

	<link rel="stylesheet" type="text/css" href="/admins/css/mws-style.css" media="screen">
	<link rel="stylesheet" type="text/css" href="/admins/css/icons/icol16.css" media="screen">
	<link rel="stylesheet" type="text/css" href="/admins/css/icons/icol32.css" media="screen">

	<!-- Demo Stylesheet -->
	<link rel="stylesheet" type="text/css" href="/admins/css/demo.css" media="screen">

	<!-- jQuery-UI Stylesheet -->
	<link rel="stylesheet" type="text/css" href="/admins/jui/css/jquery.ui.all.css" media="screen">
	<link rel="stylesheet" type="text/css" href="/admins/jui/jquery-ui.custom.css" media="screen">

	<!-- Theme Stylesheet -->
	<link rel="stylesheet" type="text/css" href="/admins/css/mws-theme.css" media="screen">
	<link rel="stylesheet" type="text/css" href="/admins/css/themer.css" media="screen">
@endsection

@section('js')
	<script src="/admins/js/libs/jquery-1.8.3.min.js"></script>
    <script src="/admins/js/libs/jquery.mousewheel.min.js"></script>
    <script src="/admins/js/libs/jquery.placeholder.min.js"></script>
    <script src="/admins/custom-plugins/fileinput.js"></script>
    
    <!-- jQuery-UI Dependent Scripts -->
    <script src="/admins/jui/js/jquery-ui-1.9.2.min.js"></script>
    <script src="/admins/jui/jquery-ui.custom.min.js"></script>
    <script src="/admins/jui/js/jquery.ui.touch-punch.js"></script>

    <script src="/admins/jui/js/globalize/globalize.js"></script>
    <script src="/admins/jui/js/globalize/cultures/globalize.culture.en-US.js"></script>

    <!-- Plugin Scripts -->
    <script src="/admins/custom-plugins/picklist/picklist.min.js"></script>
    <script src="/admins/plugins/autosize/jquery.autosize.min.js"></script>
    <script src="/admins/plugins/select2/select2.min.js"></script>
    <script src="/admins/plugins/colorpicker/colorpicker-min.js"></script>
    <script src="/admins/plugins/validate/jquery.validate-min.js"></script>
    <script src="/admins/plugins/ibutton/jquery.ibutton.min.js"></script>
    <script src="/admins/plugins/cleditor/jquery.cleditor.min.js"></script>
    <script src="/admins/plugins/cleditor/jquery.cleditor.table.min.js"></script>
    <script src="/admins/plugins/cleditor/jquery.cleditor.xhtml.min.js"></script>
    <script src="/admins/plugins/cleditor/jquery.cleditor.icon.min.js"></script>

    <!-- Core Script -->
    <script src="/admins/bootstrap/js/bootstrap.min.js"></script>
    <script src="/admins/js/core/mws.js"></script>

    <!-- Themer Script (Remove if not needed) -->
    <script src="/admins/js/core/themer.js"></script>

    <!-- Demo Scripts (remove if not needed) -->
    <script src="/admins/js/demo/demo.formelements.js"></script>
@endsection

@section('myJs')
	<script type="text/javascript">
		$(function(){
			//给状态切换按钮绑定事件
			$('.ibutton-container').click(function(){
				//获取当前元素的状态
				var status = $(this).find('input')[0].checked ? 1 : 0;
				//获取元素id
				var id = $(this).find('input').attr('uid');
				//发送ajax请求
				$.get('/cate/aupdate',{'status':status,'id':id},function(data){
					if(data == 1){
						success('更新成功');
					}else{
						error('更新失败');
					}
				});
			})

			function success(str)
			{
				//将字符串放置到div中
				$('.success').html(str);
				//显示元素
				$('.success').show();
				setTimeout(function(){
					$('.success').fadeOut();
				},3000);
			}

			function error(str)
			{
				//将字符串放置到div中
				$('.error').html(str);
				//显示元素
				$('.erroe').show();
				setTimeout(function(){
					$('.error').fadeOut();
				},3000);
			}
		})
	</script>
@endsection