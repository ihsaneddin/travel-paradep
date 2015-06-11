@section('breadcrumbs')
    {{Helpers::currentBreadcrumbs($driver)}}
@stop

@section('content')
    <div class="row">

        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{Helpers::tableTitle()}}
                </div>

                <div class="panel-body">
                    @include('admin.master.drivers.form', ['driver' => $driver])
                </div>

                <div class="panel-footer">
                <center>
                    <button class="btn btn-primary submit-form" data-target='driver-form'>Submit</button>
                    {{link_to_route('admin.master.drivers.index', 'Cancel' , [], ['class' => 'btn'])}}
                </center>
                </div>
            </div>
        </div>
    </div>
@stop

