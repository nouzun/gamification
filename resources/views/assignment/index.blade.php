@extends('layouts.dashboard')
@section('page-script')
    <script type="text/javascript">
        $(document).ready(function() {
            /*
            $(".assignment").click(function(){
                if($(this).find("a").length){
                    window.location.href = $(this).find("a:first").attr("href");
                }
            });
            */
        });
    </script>
    <style>
        .name-margin {
            margin-left: 30px;
            margin-right: 30px;
        }
        .headline-1-text {
            font-size: 16px;
            line-height: 24px;
        }
        .headline-2-text {
            font-size: 20px;
            line-height: 24px;
        }
        .headline-2-text, .headline-1-text {
            font-family: 'OpenSans-Light',Arial,sans-serif;
        }
        .horizontal-box.hover-color {
            padding-left: 30px;
            padding-right: 30px;
        }
        .od-item {
            padding-left: 0;
            padding-right: 12px;
            padding-top: 10px;
            padding-bottom: 10px;
            margin: 0;
        }
        .od-item, .od-icon {
            margin: 0 12px 0 0;
            font-size: 20px;
        }

        .input-checkbox, input[type="checkbox"]  {
            top: 8px;
            left: 10px;
            margin: 0px;
            padding: 0px;
            height: 22px;
            width: 22px;
            vertical-align: middle;
        }

        .checkbox-text {
            display: inline-block;
            vertical-align: middle;
            line-height: normal;
            padding: 0px 10px;
        }

        .checkbox-container {
            left: 0;
            height: 32px;
            vertical-align: middle;
            line-height: 32px;
        }

        .line-through {
            text-decoration: line-through;
        }
    </style>
    @stop
@section('page_heading_tree')
    @stop
@section('page_heading','Assignments')
@section('section')

<!-- Bootstrap Boilerplate... -->

<div class="panel-body">
    <!-- Display Validation Errors -->
    @include('common.errors')

    <div class="col-sm-12">
        @if( ! empty($subjects) )

            @foreach ($subjects as $subject)
                @if (count($subject->assignments) > 0)
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="row">
                                <h4 class="name-margin headline-2-text">{{ $subject->title }}</h4>
                            </div>
                            @foreach ($subject->assignments as $assignment)
                                @if ( $assignment->done == 1 )
                                    <div class="row assignment horizontal-box hover-color headline-1-text text-muted">
                                @else
                                    <div class="row assignment horizontal-box hover-color headline-1-text">
                                @endif
                                    <a href="{{ url('/assignments/subjects/'.$subject->id.'/quiz/'.$assignment->id.'/') }}">
                                        <div class="col-sm-5 od-item">
                                            <span class="fa fa-star od-icon"></span>
                                            <span>{{ $subject->title }}: Assignment {{ $assignment->id }}</span>
                                        </div>
                                    </a>
                                        <div class="col-sm-3 od-item">
                                            Due: {{ date('F d, Y', strtotime($assignment->due_date)) }}
                                        </div>
                                        <div class="col-sm-2 od-item">
                                            @if ( ! empty($assignment->point) )
                                            Point: {{ $assignment->point }}
                                            @endif
                                        </div>
                                    </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endforeach
        @endif
    </div>

</div>

@endsection