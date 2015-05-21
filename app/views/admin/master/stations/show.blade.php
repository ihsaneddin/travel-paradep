@section('breadcrumbs')
    {{Helpers::currentBreadcrumbs($station)}}
@stop

@section('content')

    <div class="box">
        <div class="container">
            <div class="panel panel-default">
              <div class="panel-heading">
                  {{Helpers::tableTitle()}}
                  <div class="pull-right panel-action">
                      <div class="btn-group">

                          {{Helpers::link_to('admin.master.stations.edit', '<i class="icon icon-pencil"></i>', ['stations' => $station->id],['class' => 'btn btn-default new-modal-form', 'data-target' => 'modal-edit-station-'.$station->id ])}}

                      </div>
                  </div>
              </div>
              <div class="panel-body">
                    <div class="col-md-6">
                      <dl class="dl-horizontal">
                          <dt>Name</dt>
                          <dd>{{ $station->name }}</dd>
                          <dt>Code</dt>
                          <dd>{{ $station->code}}</dd>
                          <dt>Address</dt>
                          <dd>{{ $station->address }}</dd>
                      </dl>
                    </div>
                    <div class="col-md-6">

                    </div>
              </div>
            </div>
        </div>
    </div>

@stop
