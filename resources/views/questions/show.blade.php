@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">{{ $question->title }}</div>
                <div class="panel-body">
                    {{--不转义, 小心xss漏洞攻击!--}}
                    {!! $question->body !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection