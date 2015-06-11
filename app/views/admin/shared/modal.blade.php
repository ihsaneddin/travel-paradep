<div class="modal fade" id="modal-admin" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content" id='modal-admin-content'>
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">
          {{ Helpers::modalTitle() }}
        </h4>
      </div>

      <div class="modal-body">
        {{$body}}
      </div>

      <div class="modal-footer">
        <center>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary btn-large submit-modal-form">Save</button>
        </center>
      </div>
    </div>
  </div>
</div>