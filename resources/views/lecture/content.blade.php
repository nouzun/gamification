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

        .assignment-easy, .assignment-easy .panel-body {
            background-color: #c4e3f3;
        }

        .assignment-easy .panel-default {
            border-color: #CCC;
        }

        .assignment-medium .panel-default {
            border-color: #CCC;
        }

        .assignment-medium, .assignment-medium .panel-body {
            background-color: #F4FF77;
        }

        .assignment-hard, .assignment-hard .panel-body {
            background-color: #ff8888;
        }

        .assignment-hard .panel-default {
            border-color: #CCC;
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
                        <div class="@if($lecture->g_achievement && !$topic->enable) disabled @endif">
                            <div class="col-sm-12">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="panel panel-default">
                                            <div class="panel-body">
                                                <a href="{{ url('/lectures/'.$lecture->id.'/subjects/'.$subject->id.'/topics/'.$topic->id.'/content') }}"><span class="topic-icon fa fa-play-circle-o"></span>{{ $topic->title }}</a>
                                                @if($lecture->g_achievement && !$topic->enable) <span class="fa fa-lock"></span> @else <span class="fa fa-unlock"> @endif
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
                                                    <div class="col-xs-2 col-sm-2 @if($assignment->difficulty_level == 1) assignment-easy @elseif($assignment->difficulty_level == 2) assignment-medium @if($lecture->level <= 1) disabled @endif @else assignment-hard @if($lecture->level <= 2) disabled @endif @endif">
                                                        <div class="panel panel-default">
                                                            <div class="panel-body">
                                                                @if (count ($assignment->questions) > 0)
                                                                    <a href="{{ url('/lectures/'.$lecture->id.'/subjects/'.$subject->id.'/topics/'.$topic->id.'/knowledgeunits/'.$knowledgeunit->id .'/assignments/'.$assignment->id.'/quiz') }}">{{ level2Text($assignment->difficulty_level) }}</a>
                                                                    @if($assignment->done)
                                                                        <i class="fa fa-check"></i>
                                                                    @endif
                                                                @else
                                                                    -
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
                    @if ($lecture->g_quest)
                        @foreach($subject->quizzes as $q_index => $quiz)
                            <div class="col-sm-12">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <a href="{{ url('/lectures/'.$subject->lecture_id.'/subjects/'.$subject->id.'/quizzes/'.$quiz->id.'/') }}">
                                            <div class="alert alert-warning">
                                                <span class="topic-icon fa fa-star"></span>Quiz {{ ($q_index + 1) }}
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            @endforeach
    </div>
@stop