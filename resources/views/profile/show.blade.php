@extends('layouts.dashboard')
@section('page_heading','User Profile')

@section('section')
        <div class="">
            <div class="row">
                <!-- left column -->
                <div class="col-md-3">
                    <div class="text-center">
                        @include('includes.avatar', ['user' => $user])
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