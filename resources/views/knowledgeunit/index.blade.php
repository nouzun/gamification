@extends('layouts.dashboard')
@section('page-script')
    <script type="text/javascript">
        $( document ).ready(function() {
        });
    </script>
@stop
@section('page_heading_tree')
    <ul class="tree">
        <li>{{ $subject->title }}</li>
        <ul>
            <li>{{ $topic->title }}</li>
        </ul>
    </ul>
@stop
@section('page_heading')
    Knowledge Units
@stop

@section('section')

<!-- Bootstrap Boilerplate... -->

<div class="panel-body">
    <!-- Display Validation Errors -->
    @include('common.errors')

    @if( ! empty($topic) )
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
                        <th>Questions</th>
                        <th>&nbsp;</th>
                        </thead>

                        <!-- Table Body -->
                        <tbody>
                        @foreach ($knowledgeunits as $knowledge_unit)
                            <tr>
                                <!-- Topic Name -->
                                <td class="table-text">
                                    <div>{{ $knowledge_unit->title }}</div>
                                </td>
                                <!-- Topic Description -->
                                <td class="table-text">
                                    <div>{{ $knowledge_unit->description }}</div>
                                </td>
                                <td class="table-text">
                                    @foreach ($knowledge_unit->questions as $question)
                                        <div>{{ $question->title }}</div>
                                    @endforeach
                                    <a href="{{ url('/subjects/'.$topic->subject_id.'/topics/'.$topic->id.'/knowledgeunits/'.$knowledge_unit->id.'/questions') }}">Add new Question</a>
                                </td>
                                <!-- Delete Button -->
                                <td>
                                    <form action="{{ url('/topic', $knowledge_unit->id) }}" method="POST">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}

                                        <button>Delete Knowledge Unit</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
        <!-- New Knowledge Unit Form -->
        <form action="{{ url('/subjects/'.$topic->subject_id.'/topics/'. $topic->id .'/knowledgeunits') }}" method="POST" class="form-horizontal">
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