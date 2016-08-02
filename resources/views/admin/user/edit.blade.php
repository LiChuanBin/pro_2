@extends('layout.admin')

@section('content')
	<div class="mws-panel grid_8">
	<div class="mws-panel-header">
    	<span class="icon-user">用户修改</span>
    </div>
    <div class="mws-panel-body no-padding">
    	<form action="/user/update" method="post" class="mws-form" enctype="multipart/form-data">
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
    					<input type="text" name="username" class="small" value="{{$info->username}}">
    				</div>
    			</div>

    			<div class="mws-form-row">
    				<label class="mws-form-label">邮箱:</label>
    				<div class="mws-form-item">
    					<input type="text" class="small" name="email" value="{{$info->email}}">
    				</div>
    			</div>

    			<div class="mws-form-row">
    				<label class="mws-form-label">手机号:</label>
    				<div class="mws-form-item">
    					<input type="text" class="small" name="phone" value="{{$info->phone}}">
    				</div>
    			</div>

    			<div class="mws-form-row">
    				<img src="{{$info->profile}}" width="200px;" alt="">
    				<label class="mws-form-label">用户头像:</label>
    				<div class="mws-form-item">
    					<input type="file" class="small" name="profile">
    				</div>
    			</div>
    			
    			
    		</div>
    		<div class="mws-button-row">
    			{{csrf_field()}}
                <!-- <input type="hidden" name="id" value="{{$info->id}}"> -->
                <input type="hidden" name="id" value="{{$info->id}}">
    			<input type="submit" class="btn btn-danger" value="更新">
    			<input type="reset" class="btn " value="重置">
    		</div>
    	</form>
    </div>    	
</div>
@endsection

@section('title','用户修改')