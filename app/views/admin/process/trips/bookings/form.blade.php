@section('script-end')
    @parent
    <script type="text/javascript" src="{{asset('assets/js/trips.js')}}"></script>
@stop

{{ Form::model($booking, ['url' => !empty($booking->id) ? route('admin.process.trips.bookings.update', array('trips' => $booking->trip_id, 'bookings' => $booking->id)) : route('admin.process.trips.bookings.store', array('trips' => $booking->trip_id)) ,
             'class' => 'form form-horizontal update-data-table form-trip box',
              'id' => 'booking-form', 'method' =>  empty($booking->id) ? 'post' : 'put', 'data-table' => 'passenger', 'data-update-list-table' => '#trip-passengers-table-list' ]) }}


  <div class="row">

    <div class="form-group col-md-12 {{ Helpers::inputError($errors, 'passenger[name]') }}">
      {{ Form::label('passenger[name]', 'Name', array('class' => 'col-md-3 control-label')) }}
      <div class="col-md-9">
        {{ Form::text('passenger[name]', $booking->passenger() ? Input::old('passenger[name]') : $booking->passenger->name,
                      array('class' => 'form-control', 'id' => 'durations')) }}
        <span class='help-inline'>
          {{ $errors->first('passenger[name]') }}
        </span>
      </div>
    </div>

    <div class="row"></div>

    <div class="form-group col-md-12 {{ Helpers::inputError($errors, 'passenger[phone]') }}">
      {{ Form::label('passenger[phone]', 'Phone Number', array('class' => 'col-md-3 control-label')) }}
      <div class="col-md-9">
        {{ Form::text('passenger[phone]', $booking->passenger() ? Input::old('passenger[phone]') : $booking->passenger->phone_no,
                      array('class' => 'form-control', 'id' => 'durations')) }}
        <span class='help-inline'>
          {{ $errors->first('passenger[phone]') }}
        </span>
      </div>
    </div>

    <div class="row"></div>

    <div class="form-group col-md-12">
        {{ Form::label('paid', 'Paid?', array('class' => 'col-md-3 control-label')) }}
        <div class="col-md-9">
            <label class="checkbox-inline">
              {{ Form::checkbox('paid', '1', $booking->paid) }}
            </label>
        </div>
    </div>

    <div class="row"></div>

    <div class="form-group {{ Helpers::inputError($errors, 'seat') }}">
      {{ Form::label('seat_no', 'Seat No', array('class' => 'col-md-3 control-label')) }}
      <div class="col-md-5">
            {{ Form::select('seat_no', $options['avalaible_seats'],
               $booking->seat_no,
               array('class' => 'form-control', 'id' => 'seat_no')) }}
        <span class='help-inline'>
          {{ $errors->first('seat_no') }}
        </span>
      </div>
    </div>

  </div>

  <span class='notify-success-text hidden'> Booking is successfully {{$booking->exists() ? 'updated' : 'created'}}. </span>

{{Form::close()}}


<script>
  $(document).ready(function(){
    $('form#booking-form').find('select').each(function(){
      if ( !$(this).hasClass('selectized') )
        {
          var select = $(this);
          initSelectize($(this), {create:false  });
        }
    });
  });
</script>