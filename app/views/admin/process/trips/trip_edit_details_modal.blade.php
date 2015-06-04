<div class="modal fade" id="edit-driver-modal" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
         <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 class="modal-title" id="myModalLabel">
          Edit Driver
        </h3>
      </div>
      <div class="modal-body">
        <div id="trip-select-driver" class="tab-pane">
          @include('admin.process.trips.drivers_list', array('trip' => $trip, 'options' => $options))
        </div>
      </div>
      <div class="modal-footer">
         <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<div class="modal fade" id="edit-car-modal" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
         <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 class="modal-title" id="myModalLabel">
          Edit Car
        </h3>
      </div>
      <div class="modal-body">
        <div id="trip-select-driver" class="tab-pane">
          @include('admin.process.trips.cars_list', array('trip' => $trip, 'options' => $options))
        </div>
      </div>
      <div class="modal-footer">
         <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>