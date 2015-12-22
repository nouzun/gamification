<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en" class="no-js">
<!--<![endif]-->
<head>
	<meta charset="utf-8"/>
	<title>SB Admin v2.0 in Laravel 5</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta content="width=device-width, initial-scale=1" name="viewport"/>
	<meta content="" name="description"/>
	<meta content="" name="author"/>
	<script type="text/javascript" src="{{ asset('assets/scripts/jquery-2.1.4.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('assets/bootstrap-3.3.6-dist/js/bootstrap.min.js') }}"></script>
	<script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script>
	<link rel="stylesheet" href="{{ asset("assets/stylesheets/styles.css") }}" />
	<link rel="stylesheet" href="{{ asset("assets/font-awesome-4.5.0/css/font-awesome.min.css") }}" />

	<script type="text/javascript" src="{{ asset('assets/summernote-master/dist/summernote.js') }}"></script>
	<link rel="stylesheet" href="{{ asset("assets/summernote-master/dist/summernote.css") }}" />
	<link rel="stylesheet" href="{{ asset("assets/stylesheets/tree.css") }}" />

	@yield('page-script')
</head>
<body>
	@yield('body')
</body>
</html>