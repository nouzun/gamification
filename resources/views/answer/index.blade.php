@extends('layouts.dashboard')
@section('page-script')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#answer-description').summernote({
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
                                <div>{!! $answer->description !!}</div>
                            </td>
                            <td class="table-text">
                                <div>{{ $answer->correct }}</div>
                            </td>
                            <!-- Delete Button -->
                            <td>
                                <div class="btn-group pull-right">
                                    <a href="{{ url('/lectures/'.$lecture_id.'/subjects/'.$subject_id.'/topics/'.$topic_id.'/knowledgeunits/'.$knowledgeunit_id.'/questions/'.$question_id.'/answers/'. $answer->id.'/edit') }}" type="button" class="btn btn-default"><i class="fa fa-edit"></i> Edit</a>
                                    <a href="{{ url('/lectures/'.$lecture_id.'/subjects/'.$subject_id.'/topics/'.$topic_id.'/knowledgeunits/'.$knowledgeunit_id.'/questions/'.$question_id.'/answers/'. $answer->id.'/destroy') }}" type="button" class="btn btn-danger"><i class="fa fa-trash-o"></i> Delete</a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif

    <!-- New Answer Form -->
    <form action="{{ url('/lectures/'.$lecture_id.'/subjects/'.$subject_id.'/topics/'. $topic_id .'/knowledgeunits/'. $knowledgeunit_id .'/questions/'.$question_id.'/answers') }}" method="POST" class="form-horizontal">
        {{ csrf_field() }}

        <!-- Answer Description -->
        <div class="form-group">
            <label for="task-name" class="col-sm-3 control-label">Description</label>

            <div class="col-sm-6">
                <textarea name="description" id="answer-description" rows="18" class="form-control">
                </textarea>
            </div>
        </div>

        <!-- Answer Correct -->
        <div class="form-group">
            <label for="task-name" class="col-sm-3 control-label">Correct?</label>

            <div class="col-sm-1">
                <input type="checkbox" name="correct" id="answer-correct" class="form-control" value="1">
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