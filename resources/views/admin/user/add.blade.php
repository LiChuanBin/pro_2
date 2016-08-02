@extends('layout.admin')

@section('content')
	<div class="mws-panel grid_8">
	<div class="mws-panel-header">
    	<span class="icon-user">用户添加</span>
    </div>
    <div class="mws-panel-body no-padding">
    	<form action="/user/insert" method="post" class="mws-form" enctype="multipart/form-data">
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
    				<label class="mws-form-label">用户名:</label>
    				<div class="mws-form-item">
    					<input type="text" name="username" class="small" value="{{old('username')}}">
    				</div>
    			</div>
    			
    			<div class="mws-form-row">
    				<label class="mws-form-label">密码:</label>
    				<div class="mws-form-item">
    					<input type="password" class="small" name="password" value="">
    				</div>
    			</div>

    			<div class="mws-form-row">
    				<label class="mws-form-label">确认密码:</label>
    				<div class="mws-form-item">
    					<input type="password" class="small" name="repassword">
    				</div>
    			</div>


    			<div class="mws-form-row">
    				<label class="mws-form-label">邮箱:</label>
    				<div class="mws-form-item">
    					<input type="text" class="small" name="email" value="{{old('email')}}">
    				</div>
    			</div>

    			<div class="mws-form-row">
    				<label class="mws-form-label">手机号:</label>
    				<div class="mws-form-item">
    					<input type="text" class="small" name="phone" value="{{old('phone')}}">
    				</div>
    			</div>

    			<div class="mws-form-row">
    				
    				<label class="mws-form-label">用户头像:</label>
    				<div class="mws-form-item">
    					<input type="file" class="small" name="profile">
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

@section('title','用户添加')