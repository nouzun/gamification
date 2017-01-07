@extends('layouts.dashboard')
@section('page_heading','Dashboard')
@section('section')
           
            <!-- /.row -->
            <div class="col-sm-12">
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-book fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">{{ \App\Subject::all()->count() }}</div>
                                    <div>Subjects!</div>
                                </div>
                            </div>
                        </div>
                        <a href="{{ url('/content') }}">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-turquoise">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-file fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">{{ \App\Topic::all()->count() }}</div>
                                    <div>Topics!</div>
                                </div>
                            </div>
                        </div>
                        <a href="{{ url('/content') }}">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-tasks fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">{{ \App\Assignment::all()->count() }}</div>
                                    <div>Assignments!</div>
                                </div>
                            </div>
                        </div>
                        <a href="{{ url('assignments') }}">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="text-center" style="margin-top: -20px"><h4>{{Auth::user()->first_name}} {{Auth::user()->last_name}}</h4></div>
                @include('includes.avatar', ['user' => Auth::user()])

                <!--
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-shopping-cart fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">124</div>
                                    <div>New Orders!</div>
                                </div>
                            </div>
                        </div>
                        <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                -->
                <!--
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-support fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">13</div>
                                    <div>Support Tickets!</div>
                                </div>
                            </div>
                        </div>
                        <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-8">
                
                @section ('pane2_panel_title', 'News Feed')
                @section ('pane2_panel_body')
                    
                    <!-- /.panel -->
              
                    <ul class="timeline">

                        @foreach (Auth::user()->timeline as $index => $feed)
                            @if ($index % 2 == 0)
                                <li>
                            @else
                                <li class="timeline-inverted">
                            @endif
                            @if ($feed->type == 'assignment')
                                    <div class="timeline-badge success"><i class="fa fa-star"></i>
                                    </div>
                                    <div class="timeline-panel">
                                        <div class="timeline-heading">
                                            <h4 class="timeline-title">You finished an Assignment</h4>
                                            <p><small class="text-muted"><i class="fa fa-clock-o"></i> {{ \Carbon\Carbon::createFromTimeStamp(strtotime($feed->date))->diffForHumans() }} </small>
                                            </p>
                                        </div>
                                        <div class="timeline-body">
                                            <p>You posted an Assignment {{ $feed->id }} and earned <strong>{{ $feed->point }}</strong> point.</p>
                                        </div>
                                    </div>
                            @elseif ($feed->type == 'quiz')
                                    <div class="timeline-badge success"><i class="fa fa-star"></i>
                                    </div>
                                    <div class="timeline-panel">
                                        <div class="timeline-heading">
                                            <h4 class="timeline-title">You finished a Quiz</h4>
                                            <p><small class="text-muted"><i class="fa fa-clock-o"></i> {{ \Carbon\Carbon::createFromTimeStamp(strtotime($feed->date))->diffForHumans() }} </small>
                                            </p>
                                        </div>
                                        <div class="timeline-body">
                                            <p>You posted a Quiz and earned <strong>{{ $feed->point }}</strong> point.</p>
                                        </div>
                                    </div>
                                @elseif ($feed->type == 'reward')
                                    <div class="timeline-badge success"><i class="fa @if(\App\Reward::find($feed->id)->type == 4) fa-trophy @else fa-certificate @endif "></i>
                                    </div>
                                    <div class="timeline-panel">
                                        <div class="timeline-heading">
                                            <h4 class="timeline-title">You earned a @if(\App\Reward::find($feed->id)->type == 4) Trophy @else Badge @endif</h4>
                                            <p><small class="text-muted"><i class="fa fa-clock-o"></i> {{ \Carbon\Carbon::createFromTimeStamp(strtotime($feed->date))->diffForHumans() }} </small>
                                            </p>
                                        </div>
                                        <div class="timeline-body">
                                            <p>You finished all easy assignments and earned a <strong>{{ \App\Reward::find($feed->id)->name }}</strong>!</p>
                                        </div>
                                    </div>
                            @elseif ($feed->type == 'reminder')
                                    <div class="timeline-badge warning"><i class="fa fa-bomb"></i>
                                    </div>
                                    <div class="timeline-panel">
                                        <div class="timeline-heading">
                                            <h4 class="timeline-title">Less than 2 days!</h4>
                                            <p><small class="text-muted"><i class="fa fa-clock-o"></i> {{ \Carbon\Carbon::createFromTimeStamp(strtotime($feed->date))->diffForHumans() }} </small>
                                            </p>
                                        </div>
                                        <div class="timeline-body">
                                            <p>You have only <strong>{{ \Carbon\Carbon::createFromTimeStamp(strtotime($feed->date))->diffForHumans() }}</strong> to finish Assignment {{ $feed->id }}. Hurry up!</p>
                                        </div>
                                    </div>
                            @endif
                            </li>
                        @endforeach
                        <!--
                        fa-check
                        <li class="timeline-inverted">
                            <div class="timeline-badge warning"><i class="fa fa-credit-card"></i>
                            </div>
                            <div class="timeline-panel">
                                <div class="timeline-heading">
                                    <h4 class="timeline-title">Lorem ipsum dolor</h4>
                                </div>
                                <div class="timeline-body">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Autem dolorem quibusdam, tenetur commodi provident cumque magni voluptatem libero, quis rerum. Fugiat esse debitis optio, tempore. Animi officiis alias, officia repellendus.</p>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Laudantium maiores odit qui est tempora eos, nostrum provident explicabo dignissimos debitis vel! Adipisci eius voluptates, ad aut recusandae minus eaque facere.</p>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="timeline-badge danger"><i class="fa fa-bomb"></i>
                            </div>
                            <div class="timeline-panel">
                                <div class="timeline-heading">
                                    <h4 class="timeline-title">Lorem ipsum dolor</h4>
                                </div>
                                <div class="timeline-body">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Repellendus numquam facilis enim eaque, tenetur nam id qui vel velit similique nihil iure molestias aliquam, voluptatem totam quaerat, magni commodi quisquam.</p>
                                </div>
                            </div>
                        </li>
                        <li class="timeline-inverted">
                            <div class="timeline-panel">
                                <div class="timeline-heading">
                                    <h4 class="timeline-title">Lorem ipsum dolor</h4>
                                </div>
                                <div class="timeline-body">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptates est quaerat asperiores sapiente, eligendi, nihil. Itaque quos, alias sapiente rerum quas odit! Aperiam officiis quidem delectus libero, omnis ut debitis!</p>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="timeline-badge info"><i class="fa fa-save"></i>
                            </div>
                            <div class="timeline-panel">
                                <div class="timeline-heading">
                                    <h4 class="timeline-title">Lorem ipsum dolor</h4>
                                </div>
                                <div class="timeline-body">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nobis minus modi quam ipsum alias at est molestiae excepturi delectus nesciunt, quibusdam debitis amet, beatae consequuntur impedit nulla qui! Laborum, atque.</p>
                                    <hr>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">
                                            <i class="fa fa-gear"></i>  <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu" role="menu">
                                            <li><a href="#">Action</a>
                                            </li>
                                            <li><a href="#">Another action</a>
                                            </li>
                                            <li><a href="#">Something else here</a>
                                            </li>
                                            <li class="divider"></li>
                                            <li><a href="#">Separated link</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="timeline-panel">
                                <div class="timeline-heading">
                                    <h4 class="timeline-title">Lorem ipsum dolor</h4>
                                </div>
                                <div class="timeline-body">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sequi fuga odio quibusdam. Iure expedita, incidunt unde quis nam! Quod, quisquam. Officia quam qui adipisci quas consequuntur nostrum sequi. Consequuntur, commodi.</p>
                                </div>
                            </div>
                        </li>
                        <li class="timeline-inverted">
                            <div class="timeline-badge success"><i class="fa fa-graduation-cap"></i>
                            </div>
                            <div class="timeline-panel">
                                <div class="timeline-heading">
                                    <h4 class="timeline-title">Lorem ipsum dolor</h4>
                                </div>
                                <div class="timeline-body">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Deserunt obcaecati, quaerat tempore officia voluptas debitis consectetur culpa amet, accusamus dolorum fugiat, animi dicta aperiam, enim incidunt quisquam maxime neque eaque.</p>
                                </div>
                            </div>
                        </li>
                        -->
                    </ul>
                        
                        <!-- /.panel-body -->
                   
                    <!-- /.panel -->
                @endsection
                @include('widgets.panel', array('header'=>true, 'as'=>'pane2'))
                </div>
                <!-- /.col-lg-8 -->
                <div class="col-lg-4">
                    @section ('points_panel_title','Points')
                    @section ('points_panel_body')
                    You have
                        <button type="button" class="btn btn-danger btn-circle    btn-lg   ">
                            {{ Auth::user()->points }}
                        </button>
                        points.
                    @endsection
                    @include('widgets.panel', array('header'=>true, 'as'=>'points'))

                    @section ('leader_board_panel_title','Leader Board')
                    @section ('leader_board_panel_body')

                        <ul class="list-group ">
                            @if (count($top_users) > 0)
                                @foreach($top_users as $selected_user)
                                    <li class="list-group-item">{{ $selected_user->first_name }} {{ $selected_user->last_name }} <span class="pull-right"><strong>{{ $selected_user->points }}</strong></span></li>
                                @endforeach
                            @endif
                        </ul>
                    @endsection
                    @include('widgets.panel', array('header'=>true, 'as'=>'leader_board'))

                </div>

                <!-- /.col-lg-4 -->
            
@stop
