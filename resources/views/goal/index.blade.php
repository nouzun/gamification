@extends('layouts.dashboard')
@section('page_heading','Goals')
@section('section')

<!-- Bootstrap Boilerplate... -->

<div class="panel-body">
    <!-- Display Validation Errors -->
    @include('common.errors')

    <!-- Current Tasks -->
    @if (count($lecture->goals) > 0)
        <div class="panel panel-default">
            <div class="panel-heading">
                Current Goals
            </div>

            <div class="panel-body">
                <table class="table table-striped task-table">

                    <!-- Table Headings -->
                    <thead>
                    <th>Goals</th>
                    <th>Description</th>
                    <th>&nbsp;</th>
                    </thead>

                    <!-- Table Body -->
                    <tbody>
                    @foreach ($lecture->goals as $goal)
                        <tr>
                            <!-- Goal Name -->
                            <td class="table-text col-md-2">
                                <div>{{ $goal->title }}</div>
                            </td>
                            <!-- Goal Description -->
                            <td class="table-text col-md-3">
                                <div>{{ $goal->description }}</div>
                            </td>
                            <!-- Delete Button -->
                            <td class="col-md-3">
                                <div class="btn-group pull-right">
                                    <a href="{{ url('/lectures/'.$lecture->id.'/goals/'.$goal->id.'/edit') }}" type="button" class="btn btn-default"><i class="fa fa-edit"></i> Edit</a>
                                    <a href="{{ url('/lectures/'.$lecture->id.'/goals/'.$goal->id.'/destroy') }}" type="button" class="btn btn-danger"><i class="fa fa-trash-o"></i> Delete</a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    <!-- New Goal Form -->
    <form action="{{ url('/lectures/'.$lecture->id.'/goals') }}" method="POST" class="form-horizontal">
        {{ csrf_field() }}

        <!-- Goal Title -->
        <div class="form-group">
            <label for="task-name" class="col-sm-3 control-label">Title</label>

            <div class="col-sm-6">
                <input type="text" name="title" id="goal-title" class="form-control">
            </div>
        </div>

        <!-- Goal Description -->
        <div class="form-group">
            <label for="task-name" class="col-sm-3 control-label">Description</label>

            <div class="col-sm-6">
                <input type="text" name="description" id="goal-description" class="form-control">
            </div>
        </div>

        <!-- Add Goal Button -->
        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-6">
                <button type="submit" class="btn btn-default">
                    <i class="fa fa-plus"></i> Add Goal
                </button>
            </div>
        </div>
    </form>
</div>

@endsection