@extends('layouts.dashboard')
@section('page-script')
    <script type="text/javascript">
        $(document).ready(function() {
            //$('#div_datetimepicker').datepicker();
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
    </style>
    @stop
@section('page_heading_tree')
    <div>
        {{ $subjectOnly->title }}
        <span class="fa fa-chevron-right"></span>
        Assignments
    </div>
    @stop
@section('page_heading','Assignments')
@section('section')

<!-- Bootstrap Boilerplate... -->

<div class="panel-body">
    <!-- Display Validation Errors -->
    @include('common.errors')
    <div class="panel panel-default">
        <div class="panel-heading">
            Current Assignments
        </div>

        <div class="panel-body">
            <table class="table table-striped task-table">

                <!-- Table Headings -->
                <thead>
                <th>Id</th>
                <th>Due Date</th>
                <th>Knowledge Units</th>
                <th>&nbsp;</th>
                </thead>

                <!-- Table Body -->
                <tbody>
                @foreach ($subjectOnly->assignments as $assignment)
                    <tr>
                        <!-- Topic Name -->
                        <td class="table-text">
                            <div>{{ $assignment->id }}</div>
                        </td>
                        <!-- Topic Description -->
                        <td class="table-text">
                            <div>{{ $assignment->due_date }}</div>
                        </td>
                        <td class="table-text">
                            @foreach ($assignment->knowledgeunits as $knowledgeunit)
                                <div>{{ $knowledgeunit->title }}</div>
                            @endforeach
                            <a href="{{ url('/subjects/'.$subjectOnly->id.'') }}">Edit Knowledge Units</a>

                        </td>
                        <!-- Delete Button -->
                        <td>
                            <form action="{{ url('/assignment', $assignment->id) }}" method="POST">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}

                                <button>Delete Assignment</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- New Assignment Form -->
    <form action="{{ url('/assignments/subjects/'.$subjectOnly->id) }}" method="POST" class="form-horizontal">
        {{ csrf_field() }}
        <div class="col-sm-12" >
            <div class="row">
                {{  $subjectOnly->title  }}
            </div>
            <div class="row">
                <div class='col-sm-2'>
                    Due Date:
                </div>
                <div class='col-sm-4'>
                    <div class="form-group">
                        <div class='input-group date' id='div_datetimepicker'>
                            <input type='date' class="form-control" name="due_date" />
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class='col-sm-2'>
                    Knowledge Units:
                </div>
                <div class='col-sm-4'>
                    @foreach ($subjectOnly->topics as $topic)
                        @foreach ($topic->knowledgeunits as $knowledgeunit)
                            <div class="row">
                                <div class="checkbox-container">
                                    <input type="checkbox" name="knowledgeunits[]" id="knowledgeunit" class="input-checkbox" value="{{ $knowledgeunit->id }}">
                                    <span class="checkbox-text">{{ $topic->title }}: {{ $knowledgeunit->title }} </span>
                                </div>
                            </div>
                        @endforeach
                    @endforeach
                </div>
            </div>
        </div>
        <!-- Add Assignment Button -->
        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-6">
                <button type="submit" class="btn btn-default">
                    <i class="fa fa-plus"></i> Create new Assignment
                </button>
            </div>
        </div>
    </form>
</div>

@endsection