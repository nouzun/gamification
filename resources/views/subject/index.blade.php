@extends('layouts.dashboard')
@section('page_heading','Subjects')
@section('section')

<!-- Bootstrap Boilerplate... -->

<div class="panel-body">
    <!-- Display Validation Errors -->
    @include('common.errors')

    <!-- Current Tasks -->
    @if (count($lecture->subjects) > 0)
        <div class="panel panel-default">
            <div class="panel-heading">
                Current Subjects
            </div>

            <div class="panel-body">
                <table class="table table-striped task-table">

                    <!-- Table Headings -->
                    <thead>
                    <th>Subjects</th>
                    <th>Description</th>
                    <th>Topics</th>
                    <th>Assignments</th>
                    <th>&nbsp;</th>
                    </thead>

                    <!-- Table Body -->
                    <tbody>
                    @foreach ($lecture->subjects as $subject)
                        <tr>
                            <!-- Subject Name -->
                            <td class="table-text col-md-2">
                                <div>{{ $subject->title }}</div>
                            </td>
                            <!-- Subject Description -->
                            <td class="table-text col-md-3">
                                <div>{{ $subject->description }}</div>
                            </td>
                            <td class="table-text col-md-2">
                                @foreach ($subject->topics as $topic)
                                    <div>{{ $topic->title }}</div>
                                @endforeach
                                <a href="{{ url('/lectures/'.$lecture->id.'/subjects/'.$subject->id.'/topics/') }}"><i class="fa fa-edit"></i> Topics</a>
                            </td>
                            <td class="table-text col-md-2">
                                @foreach ($subject->assignments as $assignment)
                                    <div>Assignment {{ $assignment->id }}</div>
                                @endforeach
                                <a href="{{ url('/lectures/'.$lecture->id.'/assignments/subjects/'.$subject->id) }}"><i class="fa fa-edit"></i> Assignments</a>
                            </td>
                            <!-- Delete Button -->
                            <td class="col-md-3">
                                <div class="btn-group pull-right">
                                    <a href="{{ url('/lectures/'.$lecture->id.'/subjects/'.$subject->id.'/edit') }}" type="button" class="btn btn-default"><i class="fa fa-edit"></i> Edit</a>
                                    <a href="{{ url('/lectures/'.$lecture->id.'/subjects/'.$subject->id.'/destroy') }}" type="button" class="btn btn-danger"><i class="fa fa-trash-o"></i> Delete</a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    <!-- New Subject Form -->
    <form action="{{ url('/lectures/'.$lecture->id.'/subjects') }}" method="POST" class="form-horizontal">
        {{ csrf_field() }}

                <!-- Subject Title -->
        <div class="form-group">
            <label for="task-name" class="col-sm-3 control-label">Title</label>

            <div class="col-sm-6">
                <input type="text" name="title" id="subject-title" class="form-control">
            </div>
        </div>

        <!-- Subject Description -->
        <div class="form-group">
            <label for="task-name" class="col-sm-3 control-label">Description</label>

            <div class="col-sm-6">
                <input type="text" name="description" id="subject-description" class="form-control">
            </div>
        </div>

        <!-- Add Subject Button -->
        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-6">
                <button type="submit" class="btn btn-default">
                    <i class="fa fa-plus"></i> Add Subject
                </button>
            </div>
        </div>
    </form>
</div>

@endsection