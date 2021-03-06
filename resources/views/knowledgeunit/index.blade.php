@extends('layouts.dashboard')
@section('page-script')
    <script type="text/javascript">
        $( document ).ready(function() {
        });
    </script>
@stop
@section('page_heading_tree')
    <div class="navigation">
        {!! $nav !!}
    </div>
@stop
@section('page_heading')
    Knowledge Units
@stop

@section('section')

<!-- Bootstrap Boilerplate... -->

<div class="panel-body">
    <!-- Display Validation Errors -->
    @include('common.errors')

    @if( ! empty($knowledgeunits) )
        <!-- Current Knowledge Units -->
        @if (count($knowledgeunits) > 0)
            <div class="panel panel-default">
                <div class="panel-heading">
                    Current Knowledge Units
                </div>

                <div class="panel-body">
                    <table class="table table-striped task-table">

                        <!-- Table Headings -->
                        <thead>
                        <th>Knowledge Units</th>
                        <th>Description</th>
                        <th>Assignments</th>
                        <th>&nbsp;</th>
                        </thead>

                        <!-- Table Body -->
                        <tbody>
                        @foreach ($knowledgeunits as $knowledge_unit)
                            <tr>
                                <!-- Knowledge Unit Name -->
                                <td class="table-text">
                                    <div>{{ $knowledge_unit->title }}</div>
                                </td>
                                <!-- Knowledge Unit Description -->
                                <td class="table-text">
                                    <div>{{ $knowledge_unit->description }}</div>
                                </td>
                                <!-- Knowledge Unit Difficult Level -->
                                <td class="table-text">

                                    @foreach ($knowledge_unit->assignments as $assignment)
                                        <div>
                                            {{ level2Text($assignment->difficulty_level) }}
                                            <a href="{{ url('/lectures/'.$lecture_id.'/subjects/'.$subject_id.'/topics/'.$topic_id.'/knowledgeunits/'.$knowledge_unit->id.'/assignments/'.$assignment->id.'/questions') }}"><i class="fa fa-edit"></i> Questions</a>
                                        </div>
                                    @endforeach
                                </td>
                                <!-- Delete Button -->
                                <td>
                                    <div class="btn-group pull-right">
                                        <a href="{{ url('/lectures/'.$lecture_id.'/subjects/'.$subject_id.'/topics/'.$topic_id.'/knowledgeunits/'.$knowledge_unit->id.'/edit') }}" type="button" class="btn btn-default"><i class="fa fa-edit"></i> Edit</a>
                                        <a href="{{ url('/lectures/'.$lecture_id.'/subjects/'.$subject_id.'/topics/'.$topic_id.'/knowledgeunits/'.$knowledge_unit->id.'/destroy') }}" type="button" class="btn btn-danger"><i class="fa fa-trash-o"></i> Delete</a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
        <!-- New Knowledge Unit Form -->
        <form action="{{ url('/lectures/'.$lecture_id.'/subjects/'.$subject_id.'/topics/'. $topic_id .'/knowledgeunits') }}" method="POST" class="form-horizontal">
            {{ csrf_field() }}

                    <!-- Knowledge Unit Title -->
            <div class="form-group">
                <label for="task-name" class="col-sm-3 control-label">Title</label>

                <div class="col-sm-6">
                    <input type="text" name="title" id="knowledgeunit-title" class="form-control">
                </div>
            </div>

            <!-- Knowledge Unit Description -->
            <div class="form-group">
                <label for="task-name" class="col-sm-3 control-label">Description</label>

                <div class="col-sm-6">
                    <input type="text" name="description" id="knowledgeunit-description" class="form-control">
                </div>
            </div>

<!--
            <div class="form-group">
                <label for="task-name" class="col-sm-3 control-label">Difficulty Level</label>

                <div class="col-sm-6">
                    <div class="btn-group" data-toggle="buttons">
                        <label class="btn btn-primary active">
                            <input name="difficulty_level" id="knowledgeunit-difficulty_level_easy" type="radio" value="1" checked="checked">Easy
                        </label>
                        <label class="btn btn-primary">
                            <input name="difficulty_level" id="knowledgeunit-difficulty_level_medium" type="radio" value="2">Medium
                        </label>
                        <label class="btn btn-primary">
                            <input name="difficulty_level" id="knowledgeunit-difficulty_level_hard" type="radio" value="3">Hard
                        </label>
                    </div>
                </div>
            </div>
-->
            <!-- Add Knowledge Unit Button -->
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-6">
                    <button type="submit" class="btn btn-default">
                        <i class="fa fa-plus"></i> Add Knowledge Unit
                    </button>
                </div>
            </div>
        </form>
    @endif
</div>
@endsection