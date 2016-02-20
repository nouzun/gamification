@extends('layouts.dashboard')
@section('page-script')
    <style>
        .lesson-box {
            border: 1px solid rgba(0,0,0,0.1);
            background-color: #fff;
        }
        .subject-box {
            padding-bottom: 18px;
        }
        .subject-title {
            margin-left: 24px;
            margin-right: 24px;
            margin-bottom: 10px;
            padding-top: 30px;
        }

        .lesson-box .subject-box:not(:first-child) {
            border-top: 1px solid rgba(0,0,0,0.12);
        }

        .topic-box {
            padding-top: 12px;
            padding-bottom: 12px;
            padding-left: 30px;
            padding-right: 30px;
            margin: 0;
            overflow: visible;
        }

        .topic-box:hover {
            background-color: #f3f3f3;
        }

        .topic-icon {
            margin-left: -2px;
            font-size: 20px;
            margin-right: 10px;
            position: relative;
            display: inline-block;
            vertical-align: middle;
            color: #32ADA1;
        }

    </style>
@stop
@section('page_heading','Course Content')
@section('section')
    <div class="lesson-box">
        @foreach(\App\Subject::all() as $s_index => $subject)
            <div class="subject-box">
                <div class="subject-title"><h4>{{ $subject->title }}</h4></div>
                @foreach($subject->topics as $t_index => $topic)
                    <div class="topic-box"><span class="topic-icon fa fa-play-circle-o"></span> {{ $topic->title }}</div>
                @endforeach
            </div>
        @endforeach
    </div>
@stop