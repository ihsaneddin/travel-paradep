@extends('layouts.base')

@section('style-head')
    <link href="{{asset('assets/css/social-coloredicons-buttons.css')}}" rel="stylesheet">
    <link href="{{asset('assets/plugins/jquery.ambiance/jquery.ambiance.css')}}" rel="stylesheet">
    <link href="{{asset('assets/css/animation.css')}}" rel="stylesheet">
    <link href="{{asset('assets/plugins/jquery.token-input/css/token-input.css')}}" rel="stylesheet">
    <link href="{{asset('assets/plugins/jquery.token-input/css/token-input-facebook.css')}}" rel="stylesheet">
    <link href="{{asset('assets/css/custom.css')}}" rel="stylesheet">
@stop

@section('body')
    <body>
        <div class="wraper">

            @include('admin.shared.sidebar')

            <div id="main">

                @include('admin.shared.navbar')

                <div id="content">
                    <div class="box">
                    
                        <h3 class='panel-title'>
                            @yield('breadcrumbs')
                        </h3>
                        
                        <div class="container">
                            @yield('content')
                        </div>
                    </div>
                </div>

                @include('admin.shared.footer')

            </div>
        </div>

        @include('admin.shared.loading')

        <div id='modal'></div>

    </body>
@stop


@section('script-end')
    <script src="{{asset('assets/plugins/jquery.ui/jquery-ui-1.10.1.custom.min.js')}}"></script>
    <script src="{{asset('assets/plugins/bootstrap-3.0.0/bootstrap.js')}}"></script>
    <script src="{{asset('assets/js/app.js')}}"></script>

    <script src="{{asset('assets/plugins/jquery.blockUI/jquery.blockUI.js')}}"></script>
    <script src="{{asset('assets/plugins/bootstrap.bootbox/bootbox.min.js')}}"></script>
    <script src="{{asset('assets/plugins/jquery.ambiance/jquery.ambiance.js')}}"></script>

    <script src="{{asset('assets/plugins/jquery.ui.touch-punch/jquery.ui.touch-punch.js')}}"></script>
    <script src="{{asset('assets/plugins/jquery.slimscroll/jquery.slimscroll.min.js')}}"></script>
    <script src="{{asset('assets/plugins/jquery.cookie/jquery.cookie.js')}}"></script>
    <script src="{{asset('assets/plugins/jquery.uipro/uipro.min.js')}}"></script>
    <script src="{{asset('assets/plugins/jquery.livefilter/jquery.liveFilter.js')}}"></script>
    <script src="{{asset('assets/js/chatboxManager.js')}}"></script>
    <script src="{{asset('assets/js/extents.js')}}"></script>
    <script src="{{asset('assets/js/sidebar.js')}}"></script>

    <script type="text/javascript" src="{{asset('assets/plugins/jquery.token-input/js/jquery.tokeninput.js')}}"></script>

    <script src="{{asset('assets/js/custom.js')}}"></script>
    <script>
          /*<![CDATA[*/
          $(function() {
            App.init();
            SideBar.init({
              shortenOnClickOutside: false
            });
          });
          /*]]>*/

        $(function(){
            var currentUrl = '{{$currentUrl}}';
            $('section.menu a').each(function(idx, elm){
                var elm = $(elm);
                if(elm.attr('href') == currentUrl){
                    elm.parents('.nav-list').addClass('in').prev().find('.accordion-toggle').addClass('opened');
                    elm.parents('.nav-list').find('[data-toggle="sub-menu-collapse"]').addClass('opened');
                    elm.addClass('active');
                }
            });
        });


    </script>
    <script type="text/javascript">
        $(function(){
            var notifcation = {};
            @if (Session::has('error'))
                notifcation = { 'type' : 'error', 'title' : 'Error', 'message' : '{{Session::get('error')}}', 'timeout' : 10 }; 
            @endif

            @if (Session::has('notice'))
                notifcation = { 'type' : 'success', 'title' : 'Notice', 'message' : '{{Session::get('notice')}}', 'timeout' : 10 };
            @endif
            if (!jQuery.isEmptyObject(notifcation))
            {
                notify(notifcation);
            }
        }); 
    </script>
@stop
