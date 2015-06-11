<div class="col-md-12">
  <h3>Booking Detail</h3>
  <dl class="dl-horizontal">
      <dt>Code</dt>
      <dd>: {{$booking->code}}</dd>
      <dt>Seat Number</dt>
      <dd>: {{$booking->seat_no}}</dd>
      <dt>Name</dt>
      <dd>: {{ $booking->passenger->name }}</dd>
      <dt>Phone</dt>
      <dd>: {{ $booking->passenger->phone}}</dd>
      <dt>Booked at</dt>
      <dd>: {{ format_date_time($booking->created_at, 'd M Y H:i') }}</dd>
  </dl>
</div>
<div class="col-md-12">
  <h3>Trip Detail</h3>
  <dl class="dl-horizontal">
      <dt>Code</dt>
      <dd>: {{ $booking->trip->code }}</dd>
      <dt>Status</dt>
      <dd>: {{ $booking->trip->pretty_state }}</dd>
      <dt>Quota</dt>
      <dd>: {{ $booking->trip->quota_status }}</dd>
      <dt>Class</dt>
      <dd>: {{ $booking->trip->pretty_class }}</dd>
      <dt>Departure Station</dt>
      <dd>: {{$booking->trip->route->departure_station}} </dd>
      <dt>Departure Time</dt>
      <dd>: {{ format_date_time($booking->trip->departure_date, 'M d Y') }}, {{ format_date_time($booking->trip->departure_hour, 'H:i') }}</dd>
      <dt>Destination Station</dt>
      <dd>: {{ $booking->trip->route->destination_station }}</dd>
      <dt>Arrival Time</dt>
      <dd>: {{ format_date_time($booking->trip->arrival_date, 'M d Y') }}, {{ format_date_time($booking->trip->arrival_hour, 'H:i') }}</dd>
  </dl>
</div>