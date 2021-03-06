@extends('layouts.dashboard')
@section('page-script')
    <script type="text/javascript">
        $( document ).ready(function() {
            $( ".select-subjects" ).change(function() {

                var subject_id = $( "select.select-subjects option:selected" ).val();
                /*
                $.ajax({
                    type: method,
                    url: url,
                    data: {a:a},//<== use object here
                    dataType:'json',// add this, as you are using res.mesg
                    success: function(res) {
                        var message = res.mesg;
                        if (message) {
                            $('.flash').html(message).fadeIn(300).delay(250).fadeOut(300);
                        };
                    }
                });
*/
                window.location = "{{ url('/') }}" + '/subjects/' + subject_id + '/topics';
            });

            $('#topic-content').summernote({
                height: "400px"
            });
        });
    </script>
@stop
@section('page_heading_tree')
    <div class="navigation">
        {!! $nav !!}
    </div>
@stop
@section('page_heading')
    Topics
@stop

@section('section')

<!-- Bootstrap Boilerplate... -->

<div class="panel-body">
    <!-- Display Validation Errors -->
    @include('common.errors')

    @if( ! empty($topics) )
        <!-- Current Tasks -->
        @if (count($topics) > 0)
            <div class="panel panel-default">
                <div class="panel-heading">
                    Current Topics
                </div>

                <div class="panel-body">
                    <table class="table table-striped task-table">

                        <!-- Table Headings -->
                        <thead>
                        <th>Topics</th>
                        <th>Description</th>
                        <th>Knowledge Units</th>
                        <th>&nbsp;</th>
                        </thead>

                        <!-- Table Body -->
                        <tbody>
                        @foreach ($topics as $topic)
                            <tr>
                                <!-- Topic Name -->
                                <td class="table-text col-md-2">
                                    <div>{{ $topic->title }}</div>
                                </td>
                                <!-- Topic Description -->
                                <td class="table-text col-md-4">
                                    <div>{{ $topic->description }}</div>
                                </td>
                                <td class="table-text col-md-2">
                                    @foreach ($topic->knowledgeunits as $knowledgeunit)
                                        <div>{{ $knowledgeunit->title }}</div>
                                    @endforeach
                                    <a href="{{ url('/lectures/'.$lecture_id.'/subjects/'.$topic->subject_id.'/topics/'.$topic->id.'/knowledgeunits') }}"><i class="fa fa-edit"></i> Knowledge Units</a>
                                </td>
                                <!-- Delete Button -->
                                <td class="col-md-2">
                                    <div class="btn-group pull-right">
                                        <a href="{{ url('/lectures/'.$lecture_id.'/subjects/'.$subject_id.'/topics/'.$topic->id.'/edit') }}" type="button" class="btn btn-default"><i class="fa fa-edit"></i> Edit</a>
                                        <a href="{{ url('/lectures/'.$lecture_id.'/subjects/'.$subject_id.'/topics/'.$topic->id.'/destroy') }}" type="button" class="btn btn-danger"><i class="fa fa-trash-o"></i> Delete</a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
        <!-- New Topic Form -->
        <form action="{{ url('/lectures/'.$lecture_id.'/subjects/'.$subject_id.'/topics') }}" method="POST" class="form-horizontal">
            {{ csrf_field() }}

                    <!-- Topic Title -->
            <div class="form-group">
                <label for="task-name" class="col-sm-2 control-label">Title</label>

                <div class="col-sm-6">
                    <input type="text" name="title" id="topic-title" class="form-control">
                </div>
            </div>

            <!-- Topic Description -->
            <div class="form-group">
                <label for="task-name" class="col-sm-2 control-label">Description</label>

                <div class="col-sm-6">
                    <input type="text" name="description" id="topic-description" class="form-control">
                </div>
            </div>

            <!-- Topic Content -->
            <div class="form-group">
                <label for="task-name" class="col-sm-2 control-label">Content</label>

                <div class="col-sm-8">
                <textarea name="topic_content" id="topic-content" rows="18" class="form-control">
                </textarea>
                </div>
            </div>

            <!-- Add Topic Button -->
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-6">
                    <button type="submit" class="btn btn-default">
                        <i class="fa fa-plus"></i> Add Topic
                    </button>
                </div>
            </div>
        </form>
    @endif
</div>
@endsection