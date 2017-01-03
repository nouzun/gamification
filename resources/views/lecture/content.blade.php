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

        .disabled {
            pointer-events:none;
            opacity: 0.5;
        }
    </style>
@stop
@section('page_heading','Course Content')
@section('section')
    <div class="lesson-box">
            @foreach($lecture->subjects as $s_index => $subject)
                <div class="subject-box">
                    <div class="subject-title">
                        <h4>
                            {{ $subject->title }} <br/>
                            <small>{{ $subject->description }}</small>
                        </h4>
                    </div>
                    @foreach($subject->topics as $t_index => $topic)
                        <div class="@if(!$topic->enable) disabled @endif">
                            <div class="col-sm-12">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="panel panel-default">
                                            <div class="panel-body">
                                                <a href="{{ url('/lectures/'.$lecture->id.'/subjects/'.$subject->id.'/topics/'.$topic->id.'/content') }}"><span class="topic-icon fa fa-play-circle-o"></span>{{ $topic->title }}</a>
                                            </div>
                                        </div>
                                        @foreach($topic->knowledgeunits as $ku_index => $knowledgeunit)
                                            <div class="row">
                                                <div class="col-xs-5 col-sm-5 col-sm-offset-1">
                                                    <div class="panel panel-default">
                                                        <div class="panel-body">
                                                            {{$knowledgeunit->title}}
                                                        </div>
                                                    </div>
                                                </div>
                                                @foreach($knowledgeunit->assignments as $assignment)
                                                    <div class="col-xs-2 col-sm-2">
                                                        <div class="panel panel-default">
                                                            <div class="panel-body">
                                                                @if ($assignment->difficulty_level == Config::get('constants.KNOWLEDGEUNIT_DIFFICULTY_LEVEL_EASY'))
                                                                    <a href="{{ url('/lectures/'.$lecture->id.'/subjects/'.$subject->id.'/topics/'.$topic->id.'/knowledgeunits/'.$knowledgeunit->id .'/quiz') }}">Easy</a>
                                                                @elseif($assignment->difficulty_level == Config::get('constants.KNOWLEDGEUNIT_DIFFICULTY_LEVEL_MEDIUM'))
                                                                    <a href="{{ url('/lectures/'.$lecture->id.'/subjects/'.$subject->id.'/topics/'.$topic->id.'/knowledgeunits/'.$knowledgeunit->id .'/quiz') }}">Medium</a>
                                                                @elseif($assignment->difficulty_level == Config::get('constants.KNOWLEDGEUNIT_DIFFICULTY_LEVEL_HARD'))
                                                                    Hard
                                                                @else
                                                                    Not defined
                                                                @endif
                                                                @if($assignment->done)
                                                                    <i class="fa fa-check"></i>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endforeach

                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endforeach
    </div>
@stop