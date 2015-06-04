@section('breadcrumbs')
    {{Helpers::currentBreadcrumbs($booking)}}
@stop

@section('content')

    <div class="box">
        <div class="container">
            <div class="panel panel-default">
              <div class="panel-heading">
                  {{Helpers::tableTitle()}}
              </div>
              <div class="panel-body">
                  @include('admin.process.bookings.detail', array('booking' => $booking))
              </div>
            </div>
        </div>
    </div>

@stop
