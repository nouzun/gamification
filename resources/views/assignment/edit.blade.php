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
                                <div>{{ $knowledgeunit->title }} <i>({{ $knowledgeunit->topic->title }})</i></div>
                            @endforeach
                        </td>
                        <!-- Delete Button -->
                        <td class="col-md-3">
                            <div class="btn-group pull-right">
                                <a href="{{ url('/lectures/'.$subjectOnly->lecture->id.'/subjects/'.$subjectOnly->id.'/edit') }}" type="button" class="btn btn-default"><i class="fa fa-edit"></i> Edit</a>
                                <a href="{{ url('/lectures/'.$subjectOnly->lecture->id.'/subjects/'.$subjectOnly->id.'/destroy') }}" type="button" class="btn btn-danger"><i class="fa fa-trash-o"></i> Delete</a>
                            </div>
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
        <div class="col-md-12" >
            <div class="row">
                {{  $subjectOnly->title  }}
            </div>
            <div class="row">
                <div class='col-md-2'>
                    Due Date:
                </div>
                <div class='col-md-4'>
                    <div class="form-group">
                        <div class='input-group date' id='div_datetimepicker'>
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                            <input type='date' class="form-control" name="due_date" min="{{ $today }}" />
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-time"></span>
                                23:59
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class='col-md-2'>
                    Knowledge Units:
                </div>
                <div class='col-md-10'>
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
            <div class="col-md-offset-2 col-md-6">
                <button type="submit" class="btn btn-default">
                    <i class="fa fa-plus"></i> Create new Assignment
                </button>
            </div>
        </div>
    </form>
</div>

@endsection