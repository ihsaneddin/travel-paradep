<table class="table" id="drivers-list">
  <thead>
    <tr>
      <th>
        Name
      </th>
      <th>
        Code
      </th>
      <th>
        Status
      </th>
      <th>&nbsp</th>
    </tr>
  </thead>
  <tbody>
    @foreach($options['all_drivers'] as $driver)
      <tr class=" {{ $trip->driver_id == $driver['id'] ? 'warning' : '' }}">
        <td>{{ $driver['name'] }}</td>
        <td>{{ $driver['code'] }}</td>
        <td>{{ $driver['state'] }}</td>
        <td>
          <a href="#" class="select-trip-option" data-target="#driver_id" data-value="{{ $driver['id'] }}" data-field="driver_id" {{ is_null($trip->id) ? '' : 'data-url ="'.route('admin.process.trips.update', array('trips' => $trip->id)).'" data-method="'.Helpers::createOrUpdateMethod($trip).'" ' }} {{ $trip->driver_id == $driver['id'] ? 'disabled=""' : '' }}>
            <i class="icon {{ $trip->driver_id == $driver['id'] ? 'icon-ok' : 'icon-check' }}"></i>
          </a>
        </td>
      </tr>
    @endforeach
  </tbody>
</table>