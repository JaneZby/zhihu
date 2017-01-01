@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    标题 {{ $question->title }}
                    <hr>
                    所属话题
                    @foreach($question->topics as $topic)
                        <span class="topic">{{ $topic->name }}</span>
                    @endforeach
                </div>
                <div class="panel-body">
                    内容
                    <hr>
                    {{--不转义, 小心xss漏洞攻击!--}}
                    {!! $question->body !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
