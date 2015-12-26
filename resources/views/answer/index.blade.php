@extends('layouts.dashboard')
@section('page-script')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#question-description').summernote({
                height: "200px"
            });
        });
    </script>
    @stop
@section('page_heading_tree')
    <ul class="tree">
        <li>{{ $subject->title }}</li>
        <ul>
            <li>{{ $topic->title }}</li>
            <ul>
                <li>{{ $knowledge_unit->title }}</li>
                <ul>
                    <li>{{ $question->title }}</li>
                </ul>
            </ul>
        </ul>
    </ul>
    @stop
@section('page_heading','Answers')
@section('section')

<!-- Bootstrap Boilerplate... -->

<div class="panel-body">
    <!-- Display Validation Errors -->
    @include('common.errors')

    <!-- Current Answers -->
    @if (count($answers) > 0)
        <div class="panel panel-default">
            <div class="panel-heading">
                Current Answers
            </div>

            <div class="panel-body">
                <table class="table table-striped task-table">

                    <!-- Table Headings -->
                    <thead>
                    <th>Description</th>
                    <th>Correct?</th>
                    <th>&nbsp;</th>
                    </thead>

                    <!-- Table Body -->
                    <tbody>
                    @foreach ($answers as $answer)
                        <tr>
                            <!-- Answer Description -->
                            <td class="table-text">
                                <div>{{ $answer->description }}</div>
                            </td>
                            <td class="table-text">
                                <div>{{ $answer->correct }}</div>
                            </td>
                            <!-- Delete Button -->
                            <td>
                                <form action="{{ url('/answer', $answer->id) }}" method="POST">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}

                                    <button>Delete Answer</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif

            <!-- New Answer Form -->
    <form action="{{ url('/subjects/'.$topic->subject_id.'/topics/'. $topic->id .'/knowledgeunits/'. $knowledge_unit->id .'/questions/'.$question->id.'/answers') }}" method="POST" class="form-horizontal">
        {{ csrf_field() }}

        <!-- Answer Description -->
        <div class="form-group">
            <label for="task-name" class="col-sm-3 control-label">Description</label>

            <div class="col-sm-6">
                <textarea name="description" id="question-description" rows="18" class="form-control">
                </textarea>
            </div>
        </div>

        <!-- Answer Correct -->
        <div class="form-group">
            <label for="task-name" class="col-sm-3 control-label">Correct?</label>

            <div class="col-sm-6">
                <input type="text" name="title" id="question-title" class="form-control">
            </div>
        </div>

        <!-- Add Answer Button -->
        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-6">
                <button type="submit" class="btn btn-default">
                    <i class="fa fa-plus"></i> Add Answer
                </button>
            </div>
        </div>
    </form>
</div>

@endsection