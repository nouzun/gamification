@extends('layouts.dashboard')
@section('page-script')
    <script type="text/javascript" src="{{ asset('assets/jquery-ui-1.11.4.custom/jquery-ui.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset("assets/jquery-ui-1.11.4.custom/jquery-ui.min.css") }}" />
    <style>
        table.sortable td{
            vertical-align: top;
        }
        #draggable, #droppable {
            border: 1px solid #eee;
            width: 142px;
            min-height: 20px;
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
        #droppable li {
            margin: 0 5px 5px 5px;
            padding: 5px;
            font-size: 1.2em;
            width: 120px;
        }

    </style>
    <script>
        $(function() {
            $( ".draggableItem" ).draggable({
                helper: "clone"
            }).disableSelection();

            $( ".connectedDroppable" ).droppable({
                hoverClass: 'ui-state-hover',
                drop: function(event, ui) {
                    tag=ui.draggable;
                    $(this).append(tag.clone().attr("id", "copysubject-" + tag.attr("id")).switchClass('ui-state-default', 'ui-state-highlight').append('<span class="pull-right"><i class="fa fa-times"></i></span>'));
                },
                accept: function(draggable) {
                    return $(this).find("#copysubject-" + draggable.attr("id")).length == 0;
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
                $(this).closest('li').remove();
            });

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
                                    <li id="subject-{{ $subject->id }}" class="draggableItem ui-state-default">{{ $subject->title }}</li>
                                @endforeach
                            </ul>
                        </td>
                        @foreach ($lecture->goals as $goal)
                            <td>
                                <ul id="droppable" class="connectedDroppable">
                                </ul>
                            </td>
                        @endforeach
                    </tr>
                </table>
            </div>
        </div>
    @endif

</div>

@endsection