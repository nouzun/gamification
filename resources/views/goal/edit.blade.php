@extends('layouts.dashboard')
@section('page-script')
@stop
@section('page_heading_tree')
    <div class="navigation">
        <a href="{{ url('/lectures/'.$lecture->id.'/goals/') }}">{{ $goal->title }}</a>
    </div>
@stop
@section('page_heading')
    Edit Goal
@stop
@section('section')
    <!-- Edit Goal Form -->
    <form action="{{ url('/lectures/'.$lecture->id.'/goals/'.$goal->id.'/edit') }}" method="POST" class="form-horizontal">
        {{ csrf_field() }}

        <!-- Goal Title -->
        <div class="form-group">
            <label for="task-name" class="col-sm-2 control-label">Title</label>

            <div class="col-sm-6">
                <input type="text" name="title" id="goal-title" class="form-control" value="{{ $goal->title }}">
            </div>
        </div>

        <!-- Goal Description -->
        <div class="form-group">
            <label for="task-name" class="col-sm-2 control-label">Description</label>

            <div class="col-sm-6">
                <input type="text" name="description" id="goal-description" class="form-control" value="{{ $goal->description }}">
            </div>
        </div>

        <!-- Update Goal Button -->
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-6">
                <button type="submit" class="btn btn-default">
                    <i class="fa fa-plus"></i> Update Goal
                </button>
            </div>
        </div>
    </form>
@endsection