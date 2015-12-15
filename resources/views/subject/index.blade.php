@extends('layouts.dashboard')
@section('page_heading','Subjects')
@section('section')

<!-- Bootstrap Boilerplate... -->

<div class="panel-body">
    <!-- Display Validation Errors -->
    @include('common.errors')

            <!-- New Subject Form -->
    <form action="{{ url('/subjects') }}" method="POST" class="form-horizontal">
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

<!-- Current Tasks -->
@if (count($subjects) > 0)
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
                <th>User</th>
                <th>&nbsp;</th>
                </thead>

                <!-- Table Body -->
                <tbody>
                @foreach ($subjects as $subject)
                    <tr>
                        <!-- Subject Name -->
                        <td class="table-text">
                            <div>{{ $subject->title }}</div>
                        </td>
                        <!-- Subject Description -->
                        <td class="table-text">
                            <div>{{ $subject->description }}</div>
                        </td>
                        <td class="table-text">
                            <div>{{ $subject->user_id }}</div>
                        </td>
                        <!-- Delete Button -->
                        <td>
                            <form action="{{ url('/subject', $subject->id) }}" method="POST">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}

                                <button>Delete Subject</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endif


@endsection