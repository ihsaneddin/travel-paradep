@section('breadcrumbs')
    {{Helpers::currentBreadcrumbs($stationable_object)}}
@stop

@section('content')
    <div class="row">

        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{Helpers::tableTitle()}}
                </div>

                <div class="panel-body">
                    @include('admin.master.shared.stationable_form', ['stationable_object' => $stationable_object])
                </div>

                <div class="panel-footer">
                <center>
                    <button class="btn btn-primary submit-form" data-target='stationable-form-{{$stationable_object->id}}' data-form-url="{{route('admin.master.'.Helpers::currentResource()['controller'].'.stationed_at', array( Helpers::currentResource()['controller'] => $stationable_object->id))}}" >Submit</button>

                </center>
                </div>
            </div>
        </div>
    </div>
@stop

