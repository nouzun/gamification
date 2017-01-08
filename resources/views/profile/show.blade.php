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
                    <div class="row">
                        <label class="col-lg-3 control-label">Role:</label>
                        @foreach( $user->roles as $role )
                            <span>{{ $role->name }}</span>
                            <br />
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                @foreach(\App\Lecture::all() as $l_index => $lecture)
                    <div class="panel panel-primary">
                        <div class="panel-heading">{{$lecture->title}} <span style="float: right">Level: {{$lecture->level}}</span></div>
                            @foreach($lecture->subjects as $index => $subject)
                                    <div class="panel-body">
                                        <a href="#">
                                            <div>
                                                <p>
                                                    <strong>{{ $subject->title }}</strong>
                                                    @if ($subject->assignmentTotal == 0)
                                                        <br />There's no assignment yet!
                                                    @endif
                                                </p>
                                                @if ($subject->assignmentTotal > 0)
                                                    <div>&nbsp;
                                                        <span class="pull-right text-muted">{{number_format($subject->assignmentDoneCount / $subject->assignmentTotal * 100, 2)}}% Completed </span>
                                                        @if ($index % 4 == 0)
                                                            @include('widgets.progress', array('animated'=> true, 'class'=>'success', 'value'=> ($subject->assignmentDoneCount / $subject->assignmentTotal * 100)))
                                                        @elseif($index % 4 == 1)
                                                            @include('widgets.progress', array('animated'=> true, 'class'=>'info', 'value'=>($subject->assignmentDoneCount / $subject->assignmentTotal * 100)))
                                                        @elseif($index % 4 == 2)
                                                            @include('widgets.progress', array('animated'=> true, 'class'=>'warning', 'value'=>($subject->assignmentDoneCount / $subject->assignmentTotal * 100)))
                                                        @else
                                                            @include('widgets.progress', array('animated'=> true, 'class'=>'danger', 'value'=>($subject->assignmentDoneCount / $subject->assignmentTotal * 100)))
                                                        @endif
                                                        <span class="sr-only">{{number_format($subject->assignmentDoneCount / $subject->assignmentTotal * 100, 2)}}% Completed</span>

                                                    </div>
                                                @endif
                                            </div>
                                        </a>
                                    </div>
                            @endforeach
                    </div>
                @endforeach

            </div>
        </div>

        @if ($user->isCurrent())
           <!-- <a href="{{url('user/'. $user->id .'/edit')}}">Edit Your Profile</a>-->
        @endif
    <br />
@endsection