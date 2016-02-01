@extends ('layouts.plane')
@section ('body')
	<div class="container">
		<div class="row">
			<div class="col-md-4 col-md-offset-4">
				<br /><br /><br />
				@section ('login_panel_title','Please Sign In')
				@section ('login_panel_body')

				@include('includes.status')
						<!--
                        <form role="form">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="E-mail" name="email" type="email" autofocus>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Password" name="password" type="password" value="">
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input name="remember" type="checkbox" value="Remember Me">Remember Me
                                    </label>
                                </div>
                                <a href="{{ url ('') }}" class="btn btn-lg btn-success btn-block">Login</a>
                            </fieldset>
                        </form>
                    -->
				<form action="#" class="form-signin">
					<p class="or-social">Or Use Social Login</p>
					<a href="{{ route('social.redirect', ['provider' => 'google']) }}" class="btn btn-lg btn-primary btn-block google" type="submit">Google</a>
				</form>
				@endsection
				@include('widgets.panel', array('as'=>'login', 'header'=>true))
			</div>
		</div>
	</div>
@stop