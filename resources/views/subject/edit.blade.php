@extends('layouts.dashboard')
@section('page-script')
@stop
@section('page_heading_tree')
    <div class="navigation">
        <a href="{{ url('/subjects/') }}">{{ $subject->title }}</a>
    </div>
@stop
@section('page_heading')
    Edit Subject
@stop
@section('section')
    <!-- Edit Subject Form -->
    <form action="{{ url('/subjects/'.$subject->id.'/edit') }}" method="POST" class="form-horizontal">
        {{ csrf_field() }}

        <!-- Subject Title -->
        <div class="form-group">
            <label for="task-name" class="col-sm-2 control-label">Title</label>

            <div class="col-sm-6">
                <input type="text" name="title" id="subject-title" class="form-control" value="{{ $subject->title }}">
            </div>
        </div>

        <!-- Subject Description -->
        <div class="form-group">
            <label for="task-name" class="col-sm-2 control-label">Description</label>

            <div class="col-sm-6">
                <input type="text" name="description" id="subject-description" class="form-control" value="{{ $subject->description }}">
            </div>
        </div>

        <!-- Update Subject Button -->
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-6">
                <button type="submit" class="btn btn-default">
                    <i class="fa fa-plus"></i> Update Subject
                </button>
            </div>
        </div>
    </form>
@endsection