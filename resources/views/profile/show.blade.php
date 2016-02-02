@extends('layouts.dashboard')
@section('page-script')
    <style>
        /**
        * Profile image component
        */
        .profile-header-container{
            margin: 0 auto;
            text-align: center;
        }

        .profile-header-img {
            padding-left: 10px;
        }

        .profile-header-img > img.img-circle {
            width: 120px;
            height: 120px;
            border: 2px solid #51D2B7;
        }

        .profile-header {
            margin-top: 43px;
        }

        /**
        * Ranking component
        */
        .rank-label-container {
            margin-top: -19px;
            /* z-index: 1000; */
            text-align: center;
        }

        .label.label-default.rank-label {
            background-color: rgb(81, 210, 183);
            padding: 5px 10px 5px 10px;
            border-radius: 27px;
        }
    </style>
@stop
@section('page_heading','User Profile')

@section('section')
<!--
        <div class="container">
            <div class="row">
                <div class="profile-header-container">
                    <div class="profile-header-img">
                        <img class="img-circle" src="//lh3.googleusercontent.com/-6V8xOA6M7BA/AAAAAAAAAAI/AAAAAAAAAAA/rzlHcD0KYwo/photo.jpg?sz=120" />

                        <div class="rank-label-container">
                            <span class="label label-default rank-label">100 puntos</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        -->
        <div class="">
            <div class="row">
                <!-- left column -->
                <div class="col-md-3">
                    <div class="text-center">
                        <div class="profile-header-container">
                            <div class="profile-header-img">
                                <img class="img-circle" src="{{ url($user->avatar->url('thumb')) }}" />
                                <div class="rank-label-container">
                                    <span class="label label-default rank-label">{{ $user->points }} points</span>
                                </div>
                            </div>
                        </div>
                        @if ($user->isCurrent())
                            <form action="{{ url('/user/'.Auth::user()->id.'/edit') }}" method="POST" enctype="multipart/form-data" class="form-horizontal">
                                {{ csrf_field() }}
                                <h6>Upload a different photo...</h6>
                                <input type="file" name="avatar" class="form-control">
                                <br />
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-6">
                                        <button type="submit" class="btn btn-default">
                                            <i class="fa fa-plus"></i> Change Avatar
                                        </button>
                                    </div>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>

                <!-- edit form column -->
                <div class="col-md-7 personal-info">
                    <h3>Personal info</h3>
                    <div class="row">
                        <label class="col-lg-3 control-label">First name:</label>
                        <span>
                            {{$user->first_name}}
                        </span>
                    </div>
                    <div class="row">
                        <label class="col-lg-3 control-label">Last name:</label>
                        <span>
                            {{$user->last_name}}
                        </span>
                    </div>
                    <div class="row">
                        <label class="col-lg-3 control-label">Email:</label>
                        <span>
                            {{$user->email}}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        @if ($user->isCurrent())
           <!-- <a href="{{url('user/'. $user->id .'/edit')}}">Edit Your Profile</a>-->
        @endif
@endsection