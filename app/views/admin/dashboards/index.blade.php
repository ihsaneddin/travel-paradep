@extends('layouts.admin')

@section('style-head')
    {{HTML::style('assets/plugins/bootstrap.datepicker/css/datepicker.css')}}
@stop

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h2 class="page-title">Dashboard</h2>
            </div>
            <div class="col-md-6">
                <form action="" class="form form-inline box pull-right" role="form">
                    <div class="form-group">
                        <input type="text" class="form-control input-date">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control input-date">
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div id="chart" style="height:200px;"></div>
        </div>
        <div class="pad-wide"></div>
        <div class="row">
            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title">General Summary</h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="box-media brand-2">
                                <div class="chart" id="chart1" style="height:40px"></div>
                                <div class="icon-check"></div>
                                <div class="info">
                                    <h3 class="title">98</h3>
                                    <small>Completed Ticket</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="box-media brand-2">
                                <div class="chart" id="chart2" style="height:40px"></div>
                                <div class="icon-bug"></div>
                                <div class="info">
                                    <h3 class="title">7</h3>
                                    <small>New Bug</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="box-media brand-2">
                                <div class="chart" id="chart3" style="height:40px"></div>
                                <h3 class="title">17</h3>
                                <small>Contributors</small>
                                <div class="icon-group"></div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="box-media brand-2">
                                <div class="chart" id="chart4" style="height:40px"></div>
                                <h3 class="title">7:45</h3>
                                <small>Average Time</small>
                                <div class="icon-time"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="pad-wide"></div>
        <div class="row">
            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title pull-left">Latest Issues</h3>
                        <div class="panel-action pull-right">
                            <div class="btn-group" data-toggle="buttons">
                                <label class="btn active">
                                    <input type="radio" name="options"> All
                                </label>
                                <label class="btn">
                                    <input type="radio" name="options"> New
                                </label>
                                <label class="btn">
                                    <input type="radio" name="options"> Closed
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table datatable table-striped table-condensed table-middle">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Status</th>
                                    <th>Issue</th>
                                    <th>Owner</th>
                                    <th class="ac">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @for($i=1;$i<=10;$i++)
                                <tr>
                                    <td>{{$i}}</td>
                                    <td>
                                        @if(rand(1,2) == 1)
                                        <span class="label label-default">Closed</span>
                                        @else
                                        <span class="label label-primary">New</span>
                                        @endif
                                    </td>
                                    <td>Blade template Form method error</td>
                                    <td><strong><a href="">Amarova Gully</a></strong></td>
                                    <td class="ac">
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-default btn-sm"><i class="icon icon-pencil"></i></button>
                                            <button type="button" class="btn btn-default btn-sm btn-delete"><i class="icon icon-trash"></i></button>
                                        </div>
                                    </td>
                                </tr>
                                @endfor
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Top Contributor</h3>
                    </div>
                    <div class="table-responsive">
                        <table class="table datatable table-striped table-condensed table-middle">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Resolved Ticket</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td><img src="{{asset('assets/img/sample/avatar.png')}}" width="50px" alt="" class="img-circle"></td>
                                    <td>
                                        <div class="progress">
                                            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 90%">
                                                <span class="sr-only">40% Complete (success)</span>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td><img src="{{asset('assets/img/sample/avatar.png')}}" width="50px" alt="" class="img-circle"></td>
                                    <td>
                                        <div class="progress">
                                            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 70%">
                                                <span class="sr-only">40% Complete (success)</span>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td><img src="{{asset('assets/img/sample/avatar.png')}}" width="50px" alt="" class="img-circle"></td>
                                    <td>
                                        <div class="progress">
                                            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 60%">
                                                <span class="sr-only">40% Complete (success)</span>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td><img src="{{asset('assets/img/sample/avatar.png')}}" width="50px" alt="" class="img-circle"></td>
                                    <td>
                                        <div class="progress">
                                            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                                                <span class="sr-only">40% Complete (success)</span>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td><img src="{{asset('assets/img/sample/avatar.png')}}" width="50px" alt="" class="img-circle"></td>
                                    <td>
                                        <div class="progress">
                                            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 20%">
                                                <span class="sr-only">40% Complete (success)</span>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('script-end')
    @parent

    {{HTML::script('assets/plugins/bootstrap.datepicker/js/bootstrap-datepicker.js')}}
    {{HTML::script('assets/plugins/jquery.flot/jquery.flot.js')}}
    {{HTML::script('assets/plugins/jquery.flot/curvedLines.js')}}

    <script type="text/javascript">
        $(function () {

            var options = {
                series: {
                    curvedLines: {
                        active: true
                    }
                },
                axis: { min:1, max: 31},
                yaxis: { min:0, max: 10000},
                xaxis: {tickLength: 0},
                colors: ['#2C3E50'],
                grid: {show: true, borderWidth:0}
            };

            var data = generateRandomData(1, 10000, 31);
            $.plot($("#chart"), [{data: data, lines: { show: true, lineWidth: 2, fill:true}, points:{show:false}, curvedLines: {apply:true}}], options);

            options.colors = ['#2980B9'];
            options.grid.show = false;
            $.plot($("#chart1"), [{data: data, bars: { show: true, lineWidth: 0, fill:true, barWidth:.9}, curvedLines: {apply:false}}], options);
            $.plot($("#chart2"), [{data: data, bars: { show: true, lineWidth: 0, fill:true, barWidth:.9}, curvedLines: {apply:false}}], options);
            $.plot($("#chart3"), [{data: data, bars: { show: true, lineWidth: 0, fill:true, barWidth:.9}, curvedLines: {apply:false}}], options);
            $.plot($("#chart4"), [{data: data, bars: { show: true, lineWidth: 0, fill:true, barWidth:.9}, curvedLines: {apply:false}}], options);
    });
    </script>
@stop
