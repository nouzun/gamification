@extends('layouts.dashboard')
@section('page-script')
    <script type="text/javascript">
        $(document).ready(function() {
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

        .answer-text {
            display: inline-block;
            vertical-align: middle;
            line-height: normal;
            padding: 0px 10px;
        }

    </style>
    @stop
@section('page_heading_tree')
    <div>
        {{ $subject->title }}
        <span class="fa fa-chevron-right"></span>
        {{ $topic->title }}
        <span class="fa fa-chevron-right"></span>
        {{ $knowledgeunit->title }} Assignment
    </div>
    @stop
@section('page_heading','Quiz')
@section('section')

<!-- Bootstrap Boilerplate... -->

<div class="panel-body">
    <!-- Display Validation Errors -->
    @include('common.errors')
    <div>{{ count($knowledgeunit->questions) }} questions</div>
    <div class="col-sm-12">
        @foreach ($knowledgeunit->questions as $index => $question)
            <div class="row">
                <div class="col-sm-1">
                    <span class="question-number">{{$index + 1}}.</span>
                </div>
                <div class="col-sm-11 single-page-question od-item ">
                    <div class="single-page-question-desc">{{ $question->description }}</div>
                    @if (count($question->correctAnswers) > 1)
                        @foreach ($question->answers as $answer)
                            <div class="row">
                                <div class="col-sm-12" >
                                    <div class="answer">
                                        <input type="checkbox" name="answer" id="quiz-answer" class="answer-checkbox">
                                        <span class="answer-text"> {{ $answer->description }} </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        @foreach ($question->answers as $answer)
                            <div class="row">
                                <div class="col-sm-12" >
                                    <div class="answer">
                                        <input type="radio" name="answer" id="quiz-answer" class="answer-checkbox">
                                        <span class="answer-text"> {{ $answer->description }} </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>

@endsection