@section('style-head')
    @parent
    <link href="{{asset('assets/plugins/datatables/media/DT_bootstrap.css')}}" rel="stylesheet">
@stop

@section('script-end')
    @parent
    <script type="text/javascript" src="{{asset('assets/plugins/datatables/media/js/jquery.dataTables.min.js')}}"></script>
    {{ $stations->script() }}
@stop

@section('breadcrumbs')
    {{Helpers::currentBreadcrumbs()}}
@stop

@section('content')
    <div class="row">

        <div class="panel panel-default">
            <div class="panel-heading">
                {{Helpers::tableTitle()}}
                <div class="pull-right panel-action">
                    <div class="btn-group">

                        {{Helpers::link_to('admin.master.stations.create', '<i class="icon icon-plus"></i>', [],['class' => 'btn btn-default new-modal-form new-object', 'data-target' => 'modal-new-station'])}}

                        <a href="#" class="btn dropdown-toggle last" data-toggle="dropdown"><i class="icon icon-gear"></i> <b class="caret"></b></a>
                        <ul class="dropdown-menu pull-right">
                            <li><a href="layouts/blank-page.html" target=&quot;_blank&quot;>Flush</a></li>
                            <li><a href="layouts/blank-page.html" target=&quot;_blank&quot;>Delete All</a></li>
                            <li class="divider"></li>
                            <li><a href="layouts/blank-page.html" target=&quot;_blank&quot;>Nothing</a></li>
                        </ul>

                    </div>
                </div>
            </div>
        </div>

        <div id='cars-table' class="table-responsive">
            {{ $stations->render() }}
        </div>
    </div>

    @include('admin.shared.confirmation')

@stop