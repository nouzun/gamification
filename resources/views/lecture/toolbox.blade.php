@extends('layouts.dashboard')
@section('page-script')
    <script type="text/javascript" src="{{ asset('assets/bootstrap-toggle-master/js/bootstrap-toggle.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset("assets/bootstrap-toggle-master/css/bootstrap-toggle.min.css") }}" />
    <script type="text/javascript">
        $( document ).ready(function() {

            $('.toolbox_module').change(function() {
                var checked = $(this).prop('checked') ? 1 : 0;
                var module_name = $(this).attr('data');
                var lecture_id = $(this).attr('lecture_id');
                var closest_a = $(this).closest('td').find("." + module_name);
                $.ajax({
                    type: "POST",
                    url: APP_URL + '/lectures/' + lecture_id + '/toolbox/store',
                    data: {"enable":checked, "module":module_name},
                    success: function( msg ) {
                        if(msg == "1"){
                            closest_a.removeClass('disabled');
                        } else {
                            closest_a.addClass('disabled');
                        }
                    }
                });
            });
        });

    </script>

    <style>
        .vmiddle {
            display: inline-block;
            vertical-align: middle;
            float: none;
        }

        .col-centered{
            text-align: center;
        }

        a.disabled {
            text-decoration:none;
            pointer-events: none;
            cursor: default;
            color:#bbb;
        }

    </style>
    @stop
@section('page_heading','Toolbox')
@section('section')

<!-- Bootstrap Boilerplate... -->

<div class="panel-body">
    <!-- Display Validation Errors -->
    @include('common.errors')

    <!-- Current Tasks -->
    @if (count($lectures) > 0)
        <div class="panel panel-default">
            <div class="panel-heading">
                Gamification Toolbox
            </div>

            <div class="panel-body">
                <table class="table table-striped task-table">

                    <!-- Table Headings -->
                    <thead>
                    <th>Lectures</th>
                    <th>Gameness Index</th>
                    <th>Modules</th>
                    </thead>

                    <!-- Table Body -->
                    <tbody>
                    @foreach ($lectures as $lecture)
                        <tr>
                            <!-- Lecture Name -->
                            <td class="table-text col-md-3">
                                <div>{{ $lecture->title }}</div>
                            </td>
                            <!-- Gameness Index -->
                            <td class="table-text col-md-2">
                                <div>3 / 5</div>
                            </td>
                            <td class="table-text">
                                <div class="col-sm-10">
                                    <div class="row">
                                        <div class="col-sm-3 col-centered">
                                            <img src="{{ asset('images/modules/reward.png') }}" />
                                        </div>
                                        <div class="col-sm-2">
                                            <input class="toolbox_module" data="g_rewarding" lecture_id="{{$lecture->id}}" type="checkbox" data-toggle="toggle" {{ ($lecture->g_rewarding == 0) ? '' : 'checked'}}>
                                        </div>
                                        <div class="col-sm-3">
                                            <a href="{{ url('/lectures/'.$lecture->id.'/toolbox/rewarding') }}" class="g_rewarding {{ ($lecture->g_rewarding == 0) ? 'disabled' : ''}}">Rewarding</a>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-3 col-centered">
                                            <img src="{{ asset('images/modules/achievement.png') }}" />
                                        </div>
                                        <div class="col-sm-2">
                                            <input class="toolbox_module" data="g_achievement" lecture_id="{{$lecture->id}}" type="checkbox" data-toggle="toggle" {{ ($lecture->g_achievement == 0) ? '' : 'checked'}}>
                                        </div>
                                        <div class="col-sm-3">
                                            <a href="{{ url('/lectures/'.$lecture->id.'/toolbox/achievement') }}" class="g_achievement {{ ($lecture->g_achievement == 0) ? 'disabled' : ''}}">Achievement</a>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-3 col-centered">
                                            <img src="{{ asset('images/modules/level.png') }}" />
                                        </div>
                                        <div class="col-sm-2">
                                            <input class="toolbox_module" data="g_level" lecture_id="{{$lecture->id}}" type="checkbox" data-toggle="toggle" {{ ($lecture->g_level == 0) ? '' : 'checked'}}>
                                        </div>
                                        <div class="col-sm-3">
                                            <a href="{{ url('/lectures/'.$lecture->id.'/toolbox/level') }}" class="g_level {{ ($lecture->g_level == 0) ? 'disabled' : ''}}">Level</a>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-3 col-centered">
                                            <img src="{{ asset('images/modules/quest.png') }}" />
                                        </div>
                                        <div class="col-sm-2">
                                            <input class="toolbox_module" data="g_quest" lecture_id="{{$lecture->id}}" type="checkbox" data-toggle="toggle" {{ ($lecture->g_quest == 0) ? '' : 'checked'}}>
                                        </div>
                                        <div class="col-sm-3">
                                            <a href="{{ url('/lectures/'.$lecture->id.'/toolbox/quest') }}" class="g_quest {{ ($lecture->g_quest == 0) ? 'disabled' : ''}}">Quest</a>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-sm-3 col-centered">
                                            <img src="{{ asset('images/modules/leaderboard.png') }}" />
                                        </div>
                                        <div class="col-sm-2">
                                            <input class="toolbox_module" data="g_leaderboard" lecture_id="{{$lecture->id}}" type="checkbox" data-toggle="toggle" {{ ($lecture->g_leaderboard == 0) ? '' : 'checked'}}>
                                        </div>
                                        <div class="col-sm-3">
                                            <a href="{{ url('/lectures/'.$lecture->id.'/toolbox/leaderboard') }}" class="g_leaderboard {{ ($lecture->g_leaderboard == 0) ? 'disabled' : ''}}">Leaderboard</a>
                                        </div>
                                    </div>

                                </div>


                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

</div>

@endsection