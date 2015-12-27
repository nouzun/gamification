@extends('layouts.dashboard')
@section('page-script')
    <script type="text/javascript">
        $(document).ready(function() {
        });
    </script>
    @stop
@section('page_heading_tree')
    <div>
        {{ $subject->title }}
        <span class="fa fa-chevron-right"></span>
        {{ $topic->title }}
        <span class="fa fa-chevron-right"></span>
        {{ $knowledgeunit->title }} Assignment
    </div>
    @stop
@section('page_heading','Quiz')
@section('section')

<!-- Bootstrap Boilerplate... -->

<div class="panel-body">
    <!-- Display Validation Errors -->
    @include('common.errors')

</div>

@endsection