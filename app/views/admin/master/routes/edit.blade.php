@section('breadcrumbs')
    {{Helpers::currentBreadcrumbs()}}
@stop

@section('content')
    <div class="row">

        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{Helpers::tableTitle()}}
                </div>

                <div class="panel-body">
                    @include('admin.master.routes.form', ['route' => $route])
                </div>

                <div class="panel-footer">
                <center>
                    <button class="btn btn-primary submit-form" data-target='route-form'>Submit</button>
                    {{link_to_route('admin.master.routes.index', 'Cancel' , [], ['class' => 'btn'])}}
                </center>
                </div>
            </div>
        </div>
    </div>
@stop

