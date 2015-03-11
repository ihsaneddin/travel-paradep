@section('breadcrumbs')
    {{Helpers::currentBreadcrumbs($car)}}
@stop

@section('content')
    
    <div class="box">
        <div class="container">
            <div class="panel panel-default">
              <div class="panel-heading">
                  {{Helpers::tableTitle()}}
                  <div class="pull-right panel-action">
                      <div class="btn-group">

                          {{Helpers::link_to('admin.master.cars.edit', '<i class="icon icon-pencil"></i>', ['cars' => $car->id],['class' => 'btn btn-default new-modal-form', 'data-target' => 'modal-edit-car-'.$car->id ])}}

                          <a href="#car-photos-upload-modal" class="btn btn-default" data-toggle='modal'>
                            <i class='icon icon-upload'></i>
                          </a>

                      </div>
                  </div>
              </div>
              <div class="panel-body">
                    <div class="col-md-6">
                      <dl class="dl-horizontal">
                          <dt>Model</dt>
                          <dd>{{ $car->model->name }}</dd>
                          <dt>Manufacture</dt>
                          <dd>{{ $car->model->manufacture }}</dd>
                          <dt>License Number</dt>
                          <dd>{{ $car->license_no }}</dd>
                          <dt>STNK Number</dt>
                          <dd>{{ $car->stnk_no }}</dd>
                          <dt>BPKB Number</dt>
                          <dd>{{ $car->bpkb_no }}</dd>
                          <dt>State</dt>
                          <dd>Not yet implemented</dd>
                          <dt>Stationed At</dt>
                          <dd>Not yet implemented</dd>
                      </dl>
                    </div>
                    <div class="col-md-6">                      

                    </div>
              </div>
            </div>
        </div>
    </div>

    @include('admin.shared.widget_blueimp')
    @include('admin.master.cars.upload_form_modal', ['car' => $car])
    @include('admin.master.cars.photos_prototype', ['car' => $car])
    
    <script type="text/javascript" src="{{asset('assets/js/car-show.js')}}"></script>

@stop
