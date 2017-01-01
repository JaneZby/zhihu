@extends('layouts.app')

@section('content')
    @include('vendor.ueditor.assets')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">发布问题</div>
                    <div class="panel-body">
                        {{--提交表单时出现了302状态错误, 和/questions有关?--}}
                        <form action="/questions/" method="post">
                            <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                                {!! csrf_field() !!}
                                <label for="title">标题</label>
                                <input type="text" name="title" value="{{ old('title') }}" placeholder="标题" id="title" class="form-control">
                                @if ($errors->has('title'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <select  name="topics[]" class="js-example-placeholder-multiple form-control js-data-example-ajax"  multiple="multiple">
                                </select>
                            </div>
                            <div class="form-group{{ $errors->has('body') ? ' has-error' : '' }}">
                                <label for="container">描述</label>
                                <!-- 编辑器容器 -->
                                <script id="container" name="body" style="height:200px" type="text/plain">
                                    {!! old('body') !!}
                                </script>

                            </div>
                            <button type="submit" class="btn btn-success pull-right">发布问题</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @section('js')
        <!-- 实例化编辑器 -->
        <script type="text/javascript">
            //绑定到id为container的html元素
            var ue = UE.getEditor('container', {
                toolbars: [
                    ['bold', 'italic', 'underline', 'strikethrough', 'blockquote', 'insertunorderedlist', 'insertorderedlist', 'justifyleft','justifycenter', 'justifyright',  'link', 'insertimage', 'fullscreen']
                ],
                elementPathEnabled: false,
                enableContextMenu: false,
                autoClearEmptyNode:true,
                wordCount:false,
                imagePopup:false,
                autotypeset:{ indent: true,imageBlockLine: 'center' }
            });
            ue.ready(function() {
                ue.execCommand('serverparam', '_token', Laravel.crsfToken); // 设置 CSRF token.
            });

            function formatTopic (topic) {
                return "<div class='select2-result-repository clearfix'>" +
                    "<div class='select2-result-repository__meta'>" +
                        "<div class='select2-result-repository__title'>" +
                            topic.name ? topic.name : "Laravel"   +
                            "</div></div></div>";
            }

            function formatTopicSelection (topic) {
                return topic.name || topic.text;//如果没有传递name,后端直接返回用户输入的topic text
            }

            $(".js-example-placeholder-multiple").select2({
                tags: true,
                placeholder: '选择相关话题',
                minimumInputLength: 2,
                ajax: {
                url: '/api/topics',
                dataType: 'json',
                delay: 250,
                data: function (params) {
                return {
                q: params.term
                };
                },
                processResults: function (data, params) {
                return {
                results: data
                };
                },
                cache: true
            },
            templateResult: formatTopic,
            templateSelection: formatTopicSelection,
            escapeMarkup: function (markup) { return markup; }
            });
        </script>
    @endsection
@endsection