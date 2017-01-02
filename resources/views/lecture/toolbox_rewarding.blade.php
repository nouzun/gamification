@extends('layouts.dashboard')
@section('page-script')
    <style>
        .vmiddle {
            display: inline-block;
            vertical-align: middle;
            float: none;
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
                            <!-- Lecture Description -->
                            <td class="table-text col-md-2">
                                <div></div>
                            </td>
                            <td class="table-text">
                                <div class="col-sm-10">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <img src="{{ asset('images/modules/reward.png') }}" />
                                        </div>
                                        <div class="col-sm-2 vmiddle">
                                            <div><a href="{{ url('/lectures/'.$lecture->id.'/toolbox/rewarding') }}">Rewarding</a></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <img src="{{ asset('images/modules/achievement.png') }}" />
                                        </div>
                                        <div class="col-sm-2 vmiddle">
                                            <a href="{{ url('/lectures/'.$lecture->id.'/toolbox/achievement') }}">Achievement</a>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <img src="{{ asset('images/modules/level.png') }}" />
                                        </div>
                                        <div class="col-sm-2 vmiddle">
                                            <a href="{{ url('/lectures/'.$lecture->id.'/toolbox/level') }}">Level</a>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <img src="{{ asset('images/modules/quest.png') }}" />
                                        </div>
                                        <div class="col-sm-2 vmiddle">
                                            <a href="{{ url('/lectures/'.$lecture->id.'/toolbox/quest') }}">Quest</a>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <img src="{{ asset('images/modules/leaderboard.png') }}" />
                                        </div>
                                        <div class="col-sm-2 vmiddle">
                                            <a href="{{ url('/lectures/'.$lecture->id.'/toolbox/leaderboard') }}">Leaderboard</a>
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