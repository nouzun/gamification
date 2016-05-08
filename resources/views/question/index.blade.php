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
    <div class="navigation">
        {!! $nav !!}
    </div>
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
                                <div>{!! $question->description !!}</div>
                            </td>
                            <td class="table-text">
                                @foreach ($question->answers as $answer)
                                    @if ($answer->correct == 1)
                                        <div class="text-success">{!! $answer->description !!}<span class="fa fa-check"></span></div>
                                    @else
                                        <div>{!! $answer->description !!}</div>
                                    @endif
                                @endforeach
                                <a href="{{ url('/lectures/'.$lecture_id.'/subjects/'.$subject_id.'/topics/'.$topic_id.'/knowledgeunits/'.$knowledgeunit_id.'/questions/'.$question->id.'/answers') }}"><i class="fa fa-edit"></i> Answers</a>

                            </td>
                            <!-- Delete Button -->
                            <td>
                                <div class="btn-group pull-right">
                                    <a href="{{ url('/lectures/'.$lecture_id.'/subjects/'.$subject_id.'/topics/'.$topic_id.'/knowledgeunits/'.$knowledgeunit_id.'/questions/'.$question->id.'/edit') }}" type="button" class="btn btn-default"><i class="fa fa-edit"></i> Edit</a>
                                    <a href="{{ url('/lectures/'.$lecture_id.'/subjects/'.$subject_id.'/topics/'.$topic_id.'/knowledgeunits/'.$knowledgeunit_id.'/questions/'.$question->id.'/destroy') }}" type="button" class="btn btn-danger"><i class="fa fa-trash-o"></i> Delete</a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif

            <!-- New Question Form -->
    <form action="{{ url('/lectures/'.$lecture_id.'/subjects/'.$subject_id.'/topics/'. $topic_id .'/knowledgeunits/'. $knowledgeunit_id .'/questions') }}" method="POST" class="form-horizontal">
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