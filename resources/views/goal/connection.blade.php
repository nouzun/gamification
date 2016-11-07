@extends('layouts.dashboard')
@section('page-script')
    <script type="text/javascript" src="{{ asset('assets/jquery-ui-1.11.4.custom/jquery-ui.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset("assets/jquery-ui-1.11.4.custom/jquery-ui.min.css") }}" />
    <style>
        table.sortable td{
            vertical-align: top;
        }
        #draggable, .connectedDroppable {
            border: 1px solid #eee;
            width: 100%;
            min-height: 100px;
            list-style-type: none;
            margin: 0;
            padding: 5px 0 0 0;
            float: left;
            margin-right: 10px;
        }
        #draggable li {
            margin: 0 5px 5px 5px;
            padding: 5px;
            font-size: 1.2em;
            width: 120px;
        }
        .connectedDroppable li {
            margin: 0 5px 5px 5px;
            padding: 5px;
            font-size: 1.2em;
            width: 120px;
        }

        i.fa {
            cursor: pointer;
        }

        .draggableItem{
            cursor: move;
        }

    </style>
    <script>
        $(function() {
            $( ".draggableItem" ).draggable({
                helper: "clone",
                cursor: "crosshair"
            }).disableSelection();

            $( ".connectedDroppable" ).droppable({
                drop: function(event, ui) {
                    tag=ui.draggable;
                    $(this).append(tag.clone().attr("id", "copysubject-" + tag.attr("data")).removeClass('draggableItem').switchClass('ui-state-default', 'ui-state-highlight').append('<span class="pull-right"><i class="fa fa-times"></i></span>'));

                    var goal_id = $(this).attr("data");
                    var subject_id = tag.attr("data");

                    $.ajax({
                        type: "POST",
                        url: APP_URL + '/lectures/' + {{ $lecture->id }} + '/goalsandsubjects',
                        data: {goal_id:goal_id, subject_id:subject_id},
                        success: function( msg ) {
                            //alert( msg );
                        }
                    });
                },
                accept: function(draggable) {
                    return $(this).find("#copysubject-" + draggable.attr("data")).length == 0;
                },
                stop: function(event, ui) {

                     if ($(ui.item).parents('.connectedDroppable').length > 0) {
                         $(ui.item).switchClass('ui-state-default', 'ui-state-highlight');

                     } else {
                         $(ui.item).switchClass('ui-state-highlight', 'ui-state-default');
                     }
                }
            }).disableSelection();

            $("ul.connectedDroppable ").on('click','li .fa-times',function(){
                var li_subject = $(this).closest('li');
                var subject_id = li_subject.attr("data");
                var goal_id = li_subject.parents('.connectedDroppable').attr("data");
                $.ajax({
                    type: "POST",
                    url: APP_URL + '/lectures/' + {{ $lecture->id }} + '/goalsandsubjects/destroy',
                    data: {goal_id:goal_id, subject_id:subject_id},
                    success: function( msg ) {
                        li_subject.remove();
                    }
                });
            });

            $( '#btn_save-connections' ).on('click', function(e) {
                /*
                e.preventDefault();
                var name = $('#name').val();
                var message = $('#message').val();
                var postid = $('#post_id').val();
                $.ajax({
                    type: "POST",
                    url: host+'/comment/add',
                    data: {name:name, message:message, post_id:postid}
                    success: function( msg ) {
                        alert( msg );
                    }
                });
                */
            });
            $("td:odd").css("background-color", "#eeeeee");
            $("th:odd").css("background-color", "#eeeeee");
        });
    </script>

@stop
@section('page_heading','Goal & Subject Connections')
@section('section')

<!-- Bootstrap Boilerplate... -->

<div class="panel-body">
    <!-- Display Validation Errors -->
    @include('common.errors')

    <!-- Current Tasks -->
    @if (count($lecture->goals) > 0)
        <div class="panel panel-default">
            <div class="panel-heading">
                Connections
            </div>
            <div class="panel-body">
                <table class="sortable">
                    <tr>
                        <th>Subjects</th>
                        @foreach ($lecture->goals as $goal)
                            <th>{{ $goal->title }}</th>
                        @endforeach
                    </tr>
                    <tr>
                        <td>
                            <ul id="draggable">
                                @foreach ($lecture->subjects as $subject)
                                    <li id="subject-{{ $subject->id }}" data="{{ $subject->id }}" class="draggableItem ui-state-default">{{ $subject->title }}</li>
                                @endforeach
                            </ul>
                        </td>
                        @foreach ($lecture->goals as $goal)
                            <td>
                                <ul data="{{ $goal->id }}" class="connectedDroppable">
                                    @foreach ($goal->subjects as $subject)
                                        <li id="copysubject-{{ $subject->id }}" data="{{ $subject->id }}" class="ui-state-highlight">{{ $subject->title }}<span class="pull-right"><i class="fa fa-times"></i></span></li>
                                    @endforeach
                                </ul>
                            </td>
                        @endforeach
                    </tr>
                </table>
                <!--
                <div class="pull-right">
                    <a id="btn_save-connections"  href="" type="button" class="btn btn-default"><i class="fa fa-save"></i> Save Connections</a>
                </div>
                -->
            </div>
        </div>
    @endif

</div>

@endsection