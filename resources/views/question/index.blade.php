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
            </ul>
        </ul>
    </ul>
    @stop
@section('page_heading','Questions')
@section('section')

<!-- Bootstrap Boilerplate... -->

<div class="panel-body">
    <!-- Display Validation Errors -->
    @include('common.errors')

    <!-- Current Questions -->
    @if (count($questions) > 0)
        <div class="panel panel-default">
            <div class="panel-heading">
                Current Questions
            </div>

            <div class="panel-body">
                <table class="table table-striped task-table">

                    <!-- Table Headings -->
                    <thead>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Answers</th>
                    <th>&nbsp;</th>
                    </thead>

                    <!-- Table Body -->
                    <tbody>
                    @foreach ($questions as $question)
                        <tr>
                            <!-- Topic Name -->
                            <td class="table-text">
                                <div>{{ $question->title }}</div>
                            </td>
                            <!-- Topic Description -->
                            <td class="table-text">
                                <div>{{ $question->description }}</div>
                            </td>
                            <td class="table-text">
                                @foreach ($question->answers as $answer)
                                    @if ($answer->correct == 1)
                                        <div class="text-success">{{ $answer->description }}<span class="fa fa-check"></span></div>
                                    @else
                                        <div>{{ $answer->description }}</div>
                                    @endif
                                @endforeach
                                <a href="{{ url('/subjects/'.$topic->subject_id.'/topics/'.$topic->id.'/knowledgeunits/'.$knowledge_unit->id.'/questions/'.$question->id.'/answers') }}">Add new Answer</a>

                            </td>
                            <!-- Delete Button -->
                            <td>
                                <form action="{{ url('/question', $question->id) }}" method="POST">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}

                                    <button>Delete Question</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif

            <!-- New Question Form -->
    <form action="{{ url('/subjects/'.$topic->subject_id.'/topics/'. $topic->id .'/knowledgeunits/'. $knowledge_unit->id .'/questions') }}" method="POST" class="form-horizontal">
        {{ csrf_field() }}

                <!-- Question Title -->
        <div class="form-group">
            <label for="task-name" class="col-sm-3 control-label">Title</label>

            <div class="col-sm-6">
                <input type="text" name="title" id="question-title" class="form-control">
            </div>
        </div>

        <!-- Question Description -->
        <div class="form-group">
            <label for="task-name" class="col-sm-3 control-label">Description</label>

            <div class="col-sm-6">
                <textarea name="description" id="question-description" rows="18" class="form-control">
                </textarea>
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