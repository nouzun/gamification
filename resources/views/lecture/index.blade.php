@extends('layouts.dashboard')
@section('page_heading','Lectures')
@section('section')

<!-- Bootstrap Boilerplate... -->

<div class="panel-body">
    <!-- Display Validation Errors -->
    @include('common.errors')

    <!-- Current Tasks -->
    @if (count($lectures) > 0)
        <div class="panel panel-default">
            <div class="panel-heading">
                Current Lectures
            </div>

            <div class="panel-body">
                <table class="table table-striped task-table">

                    <!-- Table Headings -->
                    <thead>
                    <th>Lectures</th>
                    <th>Description</th>
                    <th>Subjects</th>
                    <th>Learning Outcomes</th>
                    <th>&nbsp;</th>
                    </thead>

                    <!-- Table Body -->
                    <tbody>
                    @foreach ($lectures as $lecture)
                        <tr>
                            <!-- Lecture Name -->
                            <td class="table-text">
                                <div>{{ $lecture->title }}</div>
                            </td>
                            <!-- Lecture Description -->
                            <td class="table-text">
                                <div>{{ $lecture->description }}</div>
                            </td>
                            <td class="table-text">
                                @foreach ($lecture->subjects as $subject)
                                    <div>&bull; {{ $subject->title }}</div>
                                @endforeach
                                <a href="{{ url('/lectures/'.$lecture->id.'/subjects/') }}"><i class="fa fa-edit"></i> Subjects</a>
                            </td>
                            <td class="table-text">
                                @foreach ($lecture->goals as $goal)
                                    <div>&bull; {{ $goal->title }}</div>
                                @endforeach
                                <a href="{{ url('/lectures/'.$lecture->id.'/goals/') }}"><i class="fa fa-edit"></i> Goals</a>
                            </td>
                            <!-- Delete Button -->
                            <td class="col-sm-3">
                                <div class="btn-group pull-right">
                                    <a href="{{ url('/lectures/'.$lecture->id.'/goalsandsubjects') }}" type="button" class="btn btn-info"><i class="fa fa-random"></i> S&G</a>
                                    <a href="{{ url('/lectures/'.$lecture->id.'/edit') }}" type="button" class="btn btn-default"><i class="fa fa-edit"></i> Edit</a>
                                    <a href="{{ url('/lectures/'.$lecture->id.'/destroy') }}" type="button" class="btn btn-danger"><i class="fa fa-trash-o"></i> Delete</a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    <!-- New Lecture Form -->
    <form action="{{ url('/lectures') }}" method="POST" class="form-horizontal">
        {{ csrf_field() }}

                <!-- Lecture Title -->
        <div class="form-group">
            <label for="task-name" class="col-sm-3 control-label">Title</label>

            <div class="col-sm-6">
                <input type="text" name="title" id="lecture-title" class="form-control">
            </div>
        </div>

        <!-- Lecture Description -->
        <div class="form-group">
            <label for="task-name" class="col-sm-3 control-label">Description</label>

            <div class="col-sm-6">
                <input type="text" name="description" id="lecture-description" class="form-control">
            </div>
        </div>

        <!-- Add Lecture Button -->
        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-6">
                <button type="submit" class="btn btn-default">
                    <i class="fa fa-plus"></i> Add Lecture
                </button>
            </div>
        </div>
    </form>
</div>

@endsection