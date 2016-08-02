@extends('layout.admin')

@section('content')
    <div class="mws-panel grid_8">
    <div class="mws-panel-header">
        <span class="icon-windows">商品修改</span>
    </div>
    <div class="mws-panel-body no-padding">
        <form action="/goods/insert" method="post" class="mws-form" enctype="multipart/form-data">
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
                    <label class="mws-form-label">商品标题:</label>
                    <div class="mws-form-item">
                        <input type="text" name="title" class="small" value="{{$info->title}}">
                    </div>
                </div>
                
                <div class="mws-form-row">
                    <label class="mws-form-label">商品价格:</label>
                    <div class="mws-form-item">
                        <input type="text" name="price" class="small" value="{{$info->price}}">
                    </div>
                </div>

                <div class="mws-form-row">
                    <label class="mws-form-label">商品分类</label>
                    <div class="mws-form-item">
                        <select class="small" name="cate_id">
                            <option value="0">请选择</option>
                            @foreach($cates as $k=>$v)
                            <option value="{{$v->id}} " @if($info->cate_id == $v->id) selected @endif>{{$v->name}}</option>
                            @endforeach
                        </select> 
                    </div>
                </div>


                <div class="mws-form-row">
                    <label class="mws-form-label">商品颜色:</label>
                    <div class="mws-form-item">
                        <input type="text" name="color" class="small" value="{{$info->color}}">
                    </div>
                </div>

                <div class="mws-form-row">
                    <label class="mws-form-label">商品尺码:</label>
                    <div class="mws-form-item">
                        <input type="text" name="size" class="small" value="{{$info->size}}">
                    </div>
                </div>

                <div class="mws-form-row">
                    
                    <label class="mws-form-label">商品图片:</label>
                    <div class="mws-form-item">
                        <input type="file" class="small" name="path[]" multiple>
                    </div>
                </div>
                
                <script type="text/javascript" charset="utf-8" src="/admins/ueditor/ueditor.config.js"></script>
                <script type="text/javascript" charset="utf-8" src="/admins/ueditor/ueditor.all.min.js"> </script>
                <!--建议手动加在语言，避免在ie下有时因为加载语言失败导致编辑器加载失败-->
                <!--这里加载的语言文件会覆盖你在配置项目里添加的语言类型，比如你在配置项目里配置的是英文，这里加载的中文，那最后就是中文-->
                <script type="text/javascript" charset="utf-8" src="/admins/ueditor/lang/zh-cn/zh-cn.js"></script>

                <div class="mws-form-row">
                    <label class="mws-form-label">商品详情:</label>
                    <div class="mws-form-item">
                        <script id="editor" name="content" type="text/plain" style="width:750px;height:400px;"></script>
                    </div>
                </div>

                <script type="text/javascript">
                    //实例化编辑器
                    //建议使用工厂方法getEditor创建和引用编辑器实例，如果在某个闭包下引用该编辑器，直接调用UE.getEditor('editor')就能拿到相关的实例
                    var ue = UE.getEditor('editor');
                </script>
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

@section('title','商品添加')