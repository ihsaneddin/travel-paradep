@section('breadcrumbs')
    {{Helpers::currentBreadcrumbs()}}
@stop

@section('content')
    <div class="row">

        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{Helpers::tableTitle()}}
                </div>

                <div class="panel-body">
                    @include('admin.master.stations.form', ['station' => $station])
                </div>

                <div class="panel-footer">
                <center>
                    <button class="btn btn-primary submit-form" data-target='station-form'>Submit</button>
                    {{link_to_route('admin.master.stations.index', 'Cancel' , [], ['class' => 'btn'])}}
                </center>
                </div>
            </div>
        </div>
    </div>
@stop

