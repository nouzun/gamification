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
        });
    </script>
@stop
@section('page_heading')
    Topics
@stop

@section('section')

<!-- Bootstrap Boilerplate... -->

<div class="panel-body">
    <!-- Display Validation Errors -->
    @include('common.errors')

    <div class="form-group">
        <label>Subjects</label>
        <select class="select-subjects form-control">
            @foreach ($subjects as $s)
                @if( ! empty($subject) && $subject->id == $s->id )
                    <option value="{{ $s->id }}" selected="selected">{{ $s->title  }}</option>
                @else
                    <option value="{{ $s->id }}">{{ $s->title  }}</option>
                @endif
            @endforeach
        </select>
    </div>

    @if( ! empty($subject) )
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
                        <th>Subject</th>
                        <th>&nbsp;</th>
                        </thead>

                        <!-- Table Body -->
                        <tbody>
                        @foreach ($topics as $topic)
                            <tr>
                                <!-- Topic Name -->
                                <td class="table-text">
                                    <div><a href="{{ url('/subjects/'.$topic->subject_id.'/topics/'.$topic->id.'/knowledgeunits') }}"> {{ $topic->title }} </a></div>
                                </td>
                                <!-- Topic Description -->
                                <td class="table-text">
                                    <div>{{ $topic->description }}</div>
                                </td>
                                <td class="table-text">
                                    <div>{{ $subject->title }} ( {{ $topic->subject_id   }} )</div>
                                </td>
                                <!-- Delete Button -->
                                <td>
                                    <form action="{{ url('/topic', $topic->id) }}" method="POST">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}

                                        <button>Delete Topic</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
        <!-- New Topic Form -->
        <form action="{{ url('/subjects/'.$subject->id.'/topics') }}" method="POST" class="form-horizontal">
            {{ csrf_field() }}

                    <!-- Topic Title -->
            <div class="form-group">
                <label for="task-name" class="col-sm-3 control-label">Title</label>

                <div class="col-sm-6">
                    <input type="text" name="title" id="topic-title" class="form-control">
                </div>
            </div>

            <!-- Topic Description -->
            <div class="form-group">
                <label for="task-name" class="col-sm-3 control-label">Description</label>

                <div class="col-sm-6">
                    <input type="text" name="description" id="topic-description" class="form-control">
                </div>
            </div>

            <!-- Add Topic Button -->
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-6">
                    <button type="submit" class="btn btn-default">
                        <i class="fa fa-plus"></i> Add Topic
                    </button>
                </div>
            </div>
        </form>
    @endif
</div>
@endsection