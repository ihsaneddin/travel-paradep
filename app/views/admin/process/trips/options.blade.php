<div class="col-md-6" id="trip-input-options">
  <div class="panel panel-default">
    <div class="panel-heading">
        <h5 class="panel-title pull-left">Select Options</h5>
          <div class="pull-right panel-action">


                <ul class=" pull-right nav nav-tabs">
                    @if (is_null($trip->id))
                      <li class="active">
                        <a href="#trip-select-route" data-toggle="tab" data-target="#trip-select-route">Route</a>
                      </li>
                    @endif
                    <li class="{{ is_null($trip->id) ? '' : 'active' }}">
                      <a href="#trip-select-driver" data-toggle="tab" data-target='#trip-select-driver'>Driver</a>
                    </li>
                    <li>
                      <a href="#trip-select-car" data-toggle="tab" data-target='#trip-select-car'>Car</a>
                    </li>
                </ul>

          </div>
    </div>
    <div class="clearfix"></div>

    <div class="panel-body tab-content" style="height:150px" id="panelScroll">

      <div class="shadow shadow-top"></div>

        @if (is_null($trip->id))
          <div id="trip-select-route" class="tab-pane active">
            @include('admin.process.trips.routes_list', array('resource' => $trip, 'options' => $options))
          </div>
        @endif

        <div id="trip-select-driver" class="tab-pane {{ is_null($trip->id) ? '' : 'active' }}">
          @include('admin.process.trips.drivers_list', array('trip' => $trip, 'options' => $options))
        </div>

        <div id="trip-select-car" class="tab-pane">
        @include('admin.process.trips.cars_list', array('trip' => $trip, 'options' => $options))
        </div>
    </div>

  </div>
</div>