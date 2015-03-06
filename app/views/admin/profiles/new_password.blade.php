@section('breadcrumbs')
    {{Helpers::currentBreadcrumbs($user)}}
@stop

@section('content')
    <div class="row">
        
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{Helpers::tableTitle()}}
                </div>

                <div class="panel-body">
                    @include('admin.profiles.passowrd_form', ['user' => $user])
                </div>

                <div class="panel-footer">
                <center>
                    <button class="btn btn-primary submit-form" data-target='user-form'>Submit</button>
                    {{link_to_route('admin.dashboards.index', 'Cancel' , [], ['class' => 'btn'])}}
                </center>
                </div>
            </div>
        </div>
    </div>
@stop

