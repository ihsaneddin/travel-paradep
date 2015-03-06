<!DOCTYPE html>

<html>
	<head>
		<meta charset="utf-8">
		<title>
            Paradep Travel
            @yield('title')
        </title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="">
		<meta name="author" content="">
        <meta name="_token" content="{{ csrf_token() }}"/>

		<link rel="shortcut icon" href=" {{asset('assets/img/favicon.ico')}}"/>
		<link rel="icon" type="image/gif" href="{{asset('assets/img/favicon.gif')}}">

        <link href="{{asset('assets/css/font-awesome.css')}}" rel="stylesheet">
        <link href="{{asset('assets/css/bootstrap.css')}}" rel="stylesheet">
        <link href="{{asset('assets/css/atoz.css')}}" rel="stylesheet">
        @yield('style-head')

        <!--[if lt IE 9]>
            <script src="/assets/plugins/html5shiv.js"></script>
        <![endif]-->
        @yield('script-head')
        <script src="{{asset('assets/plugins/jquery/jquery.min.js')}}"></script>

	</head>

    @yield('body')

    @yield('script-end')

</html>