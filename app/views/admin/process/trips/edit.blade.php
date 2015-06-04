@section('breadcrumbs')
    {{Helpers::currentBreadcrumbs($trip)}}
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{Helpers::tableTitle()}}
                </div>

                <div class="panel-body">
                    @include('admin.process.trips.form', ['trip' => $trip, 'options' => $options])
                </div>

                <div class="panel-footer">
                <center>
                    <button class="btn btn-primary submit-form" data-target='trip-form'>Submit</button>
                    {{link_to_route('admin.process.trips.index', 'Cancel' , [], ['class' => 'btn'])}}
                </center>
                </div>
            </div>
        </div>
    </div>
@stop

