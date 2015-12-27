@extends('layouts.dashboard')
@section('page-script')
    <script type="text/javascript">
        $(document).ready(function() {
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
        @foreach ($subjects as $subject)
            <div class="row">
                <div class="col-sm-12">
                    <div class="row">
                        <h4 class="name-margin headline-2-text">{{ $subject->title }}</h4>
                    </div>
                    @foreach ($subject->topics as $topic)
                        @foreach ($topic->knowledgeunits as $knowledgeunit)
                        <div class="row horizontal-box hover-color headline-1-text">
                            <div class="col-sm-6 od-item">
                                <span class="fa fa-star od-icon"></span>
                                <span>{{ $topic->title }}: {{ $knowledgeunit->title }}</span>
                            </div>
                            <div class="col-sm-2 od-item">
                                Due
                            </div>
                            <div class="col-sm-2 od-item">
                                Grade
                            </div>
                        </div>
                        @endforeach
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</div>

@endsection