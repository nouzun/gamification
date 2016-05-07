@extends('layouts.dashboard')
@section('page-script')
@stop
@section('page_heading_tree')
    <div class="navigation">
        <a href="{{ url('/lectures/') }}">{{ $lecture->title }}</a>
    </div>
@stop
@section('page_heading')
    Edit Lecture
@stop
@section('section')
    <!-- Edit Lecture Form -->
    <form action="{{ url('/lectures/'.$lecture->id.'/edit') }}" method="POST" class="form-horizontal">
        {{ csrf_field() }}

        <!-- Lecture Title -->
        <div class="form-group">
            <label for="task-name" class="col-sm-2 control-label">Title</label>

            <div class="col-sm-6">
                <input type="text" name="title" id="lecture-title" class="form-control" value="{{ $lecture->title }}">
            </div>
        </div>

        <!-- Lecture Description -->
        <div class="form-group">
            <label for="task-name" class="col-sm-2 control-label">Description</label>

            <div class="col-sm-6">
                <input type="text" name="description" id="lecture-description" class="form-control" value="{{ $lecture->description }}">
            </div>
        </div>

        <!-- Update Lecture Button -->
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-6">
                <button type="submit" class="btn btn-default">
                    <i class="fa fa-plus"></i> Update Lecture
                </button>
            </div>
        </div>
    </form>
@endsection