@extends('layout.admin')

@section('content')
	<div class="mws-panel grid_8">
	<div class="mws-panel-header">
    	<span class="icon-th-list">分类添加</span>
    </div>
    <div class="mws-panel-body no-padding">
    	<form action="/cate/insert" method="post" class="mws-form" enctype="multipart/form-data">
    		@if (count($errors) > 0)
    		<div class="mws-form-message error">
            	<ul>
		            @foreach ($errors->all() as $error)
		                <li>{{ $error }}</li>
		            @endforeach
		        </ul>
            </div>
            @endif
    		<div class="mws-form-inline">
    			<div class="mws-form-row">
    				<label class="mws-form-label">分类名称:</label>
    				<div class="mws-form-item">
    					<input type="text" name="name" class="small" value="{{old('username')}}">
    				</div>
    			</div>
    			<div class="mws-form-row">
                    <label class="mws-form-label">父级分类</label>
                    <div class="mws-form-item">
                        <select class="small" name="pid">
                            <option value="0">请选择</option>
                            @foreach($cates as $k=>$v)
                            <option value="{{$v->id}}">{{$v->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="mws-form-row">
                    <label class="mws-form-label">状态</label>
                    <div class="mws-form-item clearfix">
                        <ul class="mws-form-list inline">
                            <li><input type="radio" name="status" value="1"> <label>启用</label></li>
                            <li><input type="radio" name="status" value="0"> <label>禁用</label></li>
                        </ul>
                    </div>
                </div>
    		</div>
    		<div class="mws-button-row">
    			{{csrf_field()}}
    			<input type="submit" class="btn btn-danger" value="添加">
    			<input type="reset" class="btn " value="重置">
    		</div>
    	</form>
    </div>    	
</div>
@endsection

@section('title','分类添加')