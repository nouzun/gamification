@extends('layouts.dashboard')
@section('page-script')
    <script type="text/javascript" src="{{ asset('assets/jquery-ui-1.11.4.custom/jquery-ui.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset("assets/jquery-ui-1.11.4.custom/jquery-ui.min.css") }}" />
    <style>
        table.sortable td{
            vertical-align: top;
        }
        #draggable, #sortable {
            border: 1px solid #eee;
            width: 142px;
            min-height: 20px;
            list-style-type: none;
            margin: 0;
            padding: 5px 0 0 0;
            float: left;
            margin-right: 10px;
        }
        #draggable li, #sortable li {
            margin: 0 5px 5px 5px;
            padding: 5px;
            font-size: 1.2em;
            width: 120px;
        }
    </style>
    <script>
        $(function() {
            var sortableIn = 1;
            $( ".draggableItem" ).draggable({
                connectToSortable: "#sortable",
                helper: "clone"
                /*
                remove: function(event, ui) {
                    ui.item.clone().switchClass('ui-state-default', 'ui-state-highlight').appendTo('#sortable2');
                    $(this).sortable('cancel');
                }*/
            }).disableSelection();

            $( "#sortable" ).sortable({
                over: function(e, ui) { sortableIn = 1; },
                out: function(e,i) { sortableIn = 0; },
                beforeStop: function (event, ui) {
                    if ($(ui.item).parents('#draggable').length == 0) { // Remove if its not in sortable1 list
                        if (sortableIn == 0) {
                            ui.item.remove();
                        }
                    }
                },
                start: function(event, ui) {
                    /*
                     if ($(ui.item).parents('#sortable1').length > 0) {
                     $(ui.item).addClass('dropped');
                     } else {
                     $(ui.item).addClass('sorted');
                     }
                     */
                },
                stop: function(event, ui) {
                    /*
                     if ($(ui.item).parents('#sortable1').length > 0) {
                     $(ui.item).switchClass('ui-state-highlight', 'ui-state-default');
                     } else {
                     $(ui.item).switchClass('ui-state-default', 'ui-state-highlight');
                     }
                     //$(this).sortable('cancel');

                     $(ui.item).removeClass('sorted');
                     $(ui.item).removeClass('dropped');
                     */
                }
            }).disableSelection();

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
                            <ul id="draggable" class="connectedSortable">
                                @foreach ($lecture->subjects as $subject)
                                    <li class="draggableItem ui-state-default">{{ $subject->title }}</li>
                                @endforeach
                            </ul>
                        </td>
                        @foreach ($lecture->goals as $goal)
                            <td>
                                <ul id="sortable" class="connectedSortable">
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