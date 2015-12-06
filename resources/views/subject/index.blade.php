// resources/views/subject/index.blade.php

@extends('layouts.dashboard')
@section('page_heading','Subjects')
@section('section')

        <!-- Bootstrap Boilerplate... -->

<div class="panel-body">
    <!-- Display Validation Errors -->
    @include('common.errors')

            <!-- New Subject Form -->
    <form action="/subject" method="POST" class="form-horizontal">
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

<!-- TODO: Current Subject -->
@endsection