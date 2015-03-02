@extends('layouts.base')

@section('body')
    <body class="empty">
        <div class="wraper">

            <div id="main">
                <div id="content">
                    <div class="page-front">
                        <div class="logo">
                            <img src="{{asset('assets/img/sample/logo-app.jpg')}}" alt="">
                        </div>
                        <h1 class="ac">Paradep Travel System</h1>
                        <div class="pad-wide"></div>
                        @yield('content')
                    </div>
                </div>
            </div>

        </div>
    </body>
@stop

@section('script-end')
    <script src="{{asset('assets/plugins/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('assets/plugins/jquery.ui/jquery-ui-1.10.1.custom.min.js')}}"></script>
    <script src="{{asset('assets/plugins/bootstrap-3.0.0/bootstrap.js')}}"></script>
@stop