@extends('layouts.dashboard')
@section('page-script')
    <style>
        .lesson-box {
            border: 1px solid rgba(0,0,0,0.1);
            background-color: #fff;
            margin-bottom: 0px;
        }
        .subject-box {
            margin-bottom: 0px;
        }
        .subject-title {
            margin-left: 24px;
            margin-right: 24px;
            margin-bottom: 20px;
            margin-top: 30px;
        }

        .lesson-box .subject-box:not(:first-child) {
            border-top: 0px solid rgba(0,0,0,0.12);
        }

        .topic-box {
            margin-top: 12px;
            margin-bottom: 12px;
            margin-left: 30px;
            margin-right: 30px;
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
        @foreach(\App\Lecture::all() as $l_index => $lecture)
            @foreach($lecture->subjects as $s_index => $subject)
                <div class="subject-box">
                    <div class="subject-title">
                        <h4>
                            {{ $subject->title }} <br/>
                            <small>{{ $subject->description }}</small>
                        </h4>
                    </div>
                    @foreach($subject->topics as $t_index => $topic)
                            <div class="col-sm-12">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="panel panel-default">
                                            <div class="panel-body">
                                                <a href="{{ url('/lectures/'.$lecture->id.'/subjects/'.$subject->id.'/topics/'.$topic->id) }}"><span class="topic-icon fa fa-play-circle-o"></span>{{ $topic->title }}</a>
                                            </div>
                                        </div>
                                    </div>
                                    @foreach($topic->knowledgeunits as $ku_index => $knowledgeunit)
                                    <div class="col-sm-2">
                                        <div class="panel panel-default">
                                            <div class="panel-body">
                                                @if ($knowledgeunit->difficulty_level == Config::get('constants.KNOWLEDGEUNIT_DIFFICULTY_LEVEL_EASY'))
                                                    Easy
                                                @elseif($knowledgeunit->difficulty_level == Config::get('constants.KNOWLEDGEUNIT_DIFFICULTY_LEVEL_MEDIUM'))
                                                    Medium
                                                @elseif($knowledgeunit->difficulty_level == Config::get('constants.KNOWLEDGEUNIT_DIFFICULTY_LEVEL_HARD'))
                                                    Hard
                                                @else
                                                    Not defined
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                </div>
            @endforeach
        @endforeach
    </div>
@stop