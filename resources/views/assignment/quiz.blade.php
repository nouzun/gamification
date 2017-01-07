@extends('layouts.dashboard')
@section('page-script')
    <script type="text/javascript">
        $(document).ready(function() {
            var done = {{ $assignment->done }};
            if (done == 1) {
                $('#form-quiz').find(':input').prop('disabled', true);
            }
        });
    </script>
    <style>
        .question-number {
            font-size: 1.4em;

        }
        .single-page-question {
            border-bottom: 2px solid rgba(0, 0, 0, 0.12);
            font-size: 16px;
            margin-bottom: 30px;
            padding: 4px 50px 24px 42px;
        }
        .single-page-question-desc {
            margin-bottom: 12px;
        }
        .od-item {
            padding-left: 0;
            padding-right: 12px;
            padding-top: 10px;
            padding-bottom: 10px;
            margin: 0;
            left: 0;
            text-align: left;
        }
        .answer {
            height: 32px;
            vertical-align: middle;
            line-height: 32px;
            margin-bottom: 2px;
            border: 1px solid transparent;
            border-radius: 4px;
        }

        .answer-checkbox, input[type="checkbox"]  {
            top: 8px;
            left: 10px;
            margin: 0px;
            padding: 0px;
            height: 22px;
            width: 22px;
            vertical-align: middle;
        }

        .answer-radio, input[type="radio"]  {
            top: 8px;
            left: 10px;
            margin: 0px;
            padding: 0px;
            height: 22px;
            width: 22px;
            vertical-align: middle;
        }

        .answer-text {
            display: inline-block;
            vertical-align: middle;
            line-height: normal;
            padding: 0px 10px;
        }

        .answer-success {
            color: #3c763d;
            background-color: #dff0d8;
            border-color: #d6e9c6;
        }
        .bronze-badge {
            font-size: 40px;
        }

    </style>
    @stop
@section('page_heading_tree')
    <div class="navigation">
        {!! $nav !!}
    </div>
    @stop
@section('page_heading','Quiz')
@section('section')

<!-- Bootstrap Boilerplate... -->

<div class="panel-body">
    <!-- Display Validation Errors -->
    @include('common.errors')
    @if ( $assignment->done == 1 )
        @if ($lecture->g_rewarding)
            @if ($goal_done)
                <div class="alert alert-info" style="text-align: center">
                    Congratulations you reached a goal and earned a Trophy!</br>
                    <span class="bronze-badge fa fa-trophy"></span>
                </div>
            @endif
            @if ($all_easy_done)
                <div class="alert alert-info" style="text-align: center">
                    Congratulations you finished all easy assignments and earned a Bronze Badge!</br>
                    <span class="bronze-badge fa fa-certificate"></span>
                </div>
            @endif
            <div class="alert alert-success " role="alert">
                <i class="fa fa-user"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  You completed this assignment and earned <strong>{{ $assignment->point }}</strong> points.
            </div>
        @endif
    @endif
    <div>{{ count($questionsAll) }} questions</div>
    <form action="{{ url('/lectures/'.$lecture->id.'/subjects/'.$subject_id.'/topics/'.$topic_id.'/knowledgeunits/'. $knowledgeunit_id.'/assignments/'.$assignment->id.'/quiz' ) }}" method="POST" class="form-horizontal" id ="form-quiz">
        {{ csrf_field() }}
        <div class="col-sm-12">
            @foreach ($questionsAll as $index => $question)
                <div class="row">
                    <div class="col-sm-1">
                        <span class="question-number">{{$index + 1}}.</span>
                    </div>
                    <div class="col-sm-11 single-page-question od-item ">
                        <div class="single-page-question-desc">{!! $question->description !!}</div>
                        @if (count($question->correctAnswers) > 1)
                            @foreach ($question->answers as $answer)
                                <div class="row">
                                    <div class="col-sm-12" >
                                        @if ($assignment->done && $answer->correct)
                                            <div class="answer answer-success">
                                        @else
                                            <div class="answer">
                                        @endif
                                        @if ( $assignment->done && Auth::User()->answers->contains($answer->id) )
                                            <input type="checkbox" name="answers[{{$index}}]" id="quiz-answer" class="answer-checkbox" value="{{ $answer->id }}" checked="checked">
                                        @else
                                            <input type="checkbox" name="answers[{{$index}}]" id="quiz-answer" class="answer-checkbox" value="{{ $answer->id }}">
                                        @endif
                                            <span class="answer-text"> {!! $answer->description !!} </span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            @foreach ($question->answers as $answer)
                                <div class="row">
                                    <div class="col-sm-12" >
                                        @if ($assignment->done && $answer->correct)
                                            <div class="answer answer-success">
                                        @else
                                            <div class="answer">
                                        @endif
                                        @if ( $assignment->done && Auth::User()->answers->contains($answer->id) )
                                            <input type="radio" name="answers[{{$index}}]" id="quiz-answer" class="answer-radio" value="{{ $answer->id }}" checked="checked">
                                        @else
                                            <input type="radio" name="answers[{{$index}}]" id="quiz-answer" class="answer-radio" value="{{ $answer->id }}">
                                        @endif
                                            <span class="answer-text"> {!! $answer->description !!} </span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
        @if ( $assignment->done != 1 )
        <div class="form-group">
            <div class="col-sm-12" style="text-align: right">
                <button type="submit" class="btn btn-default">
                    <i class="fa fa-send"></i> Submit Assignment
                </button>
            </div>
        </div>
        @endif
    </form>
</div>

@endsection