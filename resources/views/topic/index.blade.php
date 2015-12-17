@extends('layouts.dashboard')
@section('page_heading')
    {{ $subject->title }} -> Topics
    @stop

@section('section')

<!-- Bootstrap Boilerplate... -->

<div class="panel-body">
    <!-- Display Validation Errors -->
    @include('common.errors')

    <div class="form-group">
        <label>Subjects</label>
        <select class="form-control">
            <option>1</option>
            <option>2</option>
            <option>3</option>
            <option>4</option>
            <option>5</option>
        </select>
    </div>

            <!-- New Topic Form -->
    <form action="{{ url('/subjects/'.$subject->id.'/topics') }}" method="POST" class="form-horizontal">
        {{ csrf_field() }}

                <!-- Topic Title -->
        <div class="form-group">
            <label for="task-name" class="col-sm-3 control-label">Title</label>

            <div class="col-sm-6">
                <input type="text" name="title" id="topic-title" class="form-control">
            </div>
        </div>

        <!-- Topic Description -->
        <div class="form-group">
            <label for="task-name" class="col-sm-3 control-label">Description</label>

            <div class="col-sm-6">
                <input type="text" name="description" id="topic-description" class="form-control">
            </div>
        </div>

        <!-- Add Topic Button -->
        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-6">
                <button type="submit" class="btn btn-default">
                    <i class="fa fa-plus"></i> Add Topic
                </button>
            </div>
        </div>
    </form>
</div>

<!-- Current Tasks -->
@if (count($topics) > 0)
    <div class="panel panel-default">
        <div class="panel-heading">
            Current Topics
        </div>

        <div class="panel-body">
            <table class="table table-striped task-table">

                <!-- Table Headings -->
                <thead>
                <th>Topics</th>
                <th>Description</th>
                <th>Subject</th>
                <th>&nbsp;</th>
                </thead>

                <!-- Table Body -->
                <tbody>
                @foreach ($topics as $topic)
                    <tr>
                        <!-- Topic Name -->
                        <td class="table-text">
                            <div>{{ $topic->title }}</div>
                        </td>
                        <!-- Topic Description -->
                        <td class="table-text">
                            <div>{{ $topic->description }}</div>
                        </td>
                        <td class="table-text">
                            <div>{{ $subject->title }} ( {{ $topic->subject_id   }} )</div>
                        </td>
                        <!-- Delete Button -->
                        <td>
                            <form action="{{ url('/topic', $topic->id) }}" method="POST">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}

                                <button>Delete Topic</button>
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