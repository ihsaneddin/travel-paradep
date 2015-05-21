@section('breadcrumbs')
    {{Helpers::currentBreadcrumbs($driver)}}
@stop

@section('content')

    <div class="box">
        <div class="container">
            <div class="panel panel-default">
              <div class="panel-heading">
                  {{Helpers::tableTitle()}}
                  <div class="pull-right panel-action">
                      <div class="btn-group">

                          {{Helpers::link_to('admin.master.drivers.edit', '<i class="icon icon-pencil"></i>', ['drivers' => $driver->id],['class' => 'btn btn-default new-modal-form', 'data-target' => 'modal-edit-driver-'.$driver->id ])}}

                      </div>
                  </div>
              </div>
              <div class="panel-body">
                    <div class="col-md-6">
                      <dl class="dl-horizontal">
                          <dt>Name</dt>
                          <dd>:{{ $driver->name }}</dd>
                          <dt>Code</dt>
                          <dd>:{{ $driver->code}}</dd>
                          <dt>Drive Hours</dt>
                          <dd>:{{ $driver->drive_hours }} hour(s)</dd>
                      </dl>
                    </div>
                    <div class="col-md-6">

                    </div>
              </div>
            </div>
        </div>
    </div>

@stop
