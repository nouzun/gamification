// resources/views/tasks/index.blade.php

@extends('layouts.dashboard')
@section('page_heading','Questions')
@section('section')

        <!-- Bootstrap Boilerplate... -->

<div class="panel-body">
    <!-- Display Validation Errors -->
    @include('common.errors')

            <!-- New Question Form -->
    <form action="/question" method="POST" class="form-horizontal">
        {{ csrf_field() }}

                <!-- Question Name -->
        <div class="form-group">
            <label for="task-name" class="col-sm-3 control-label">Question</label>

            <div class="col-sm-6">
                <input type="text" name="description" id="question-description" class="form-control">
            </div>
        </div>

        <!-- Add Question Button -->
        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-6">
                <button type="submit" class="btn btn-default">
                    <i class="fa fa-plus"></i> Add Question
                </button>
            </div>
        </div>
    </form>
</div>

<!-- TODO: Current Question -->
@endsection