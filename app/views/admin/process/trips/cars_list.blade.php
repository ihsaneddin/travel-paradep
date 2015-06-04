<table class="table" id="cars-list">
  <thead>
    <tr>
      <th>
        Code
      </th>
      <th>
        Model
      </th>
      <th>
        Class
      </th>
      <th>
        Seat
      </th>
      <th>
        Status
      </th>
      <th>&nbsp</th>
    </tr>
  </thead>
  <tbody>
    @foreach($options['all_cars'] as $car)
      <tr class=" {{ $trip->travel_car_id == $car['id'] ? 'warning' : '' }}">
        <td>{{ $car['code'] }}</td>
        <td>{{ $car['merk'] }}</td>
        <td>{{ $car['class'] }}</td>
        <td>{{ $car['seat'] }}</td>
        <td>{{ $car['state'] }}</td>
        <td>
          <a href="#" class="select-trip-option" data-target="#travel_car_id" data-value="{{ $car['id'] }}" data-field="travel_car_id" {{ is_null($trip->id) ? '' : 'data-url ="'.route('admin.process.trips.update', array('trips' => $trip->id)).'" data-method="'.Helpers::createOrUpdateMethod($trip).'" ' }} {{ $trip->route_id == $car['id'] ? 'disabled=""' : '' }}>
            <i class="icon {{ $trip->travel_car_id == $car['id'] ? 'icon-ok' : 'icon-check' }}"></i>
          </a>
        </td>
      </tr>
    @endforeach
  </tbody>
</table>