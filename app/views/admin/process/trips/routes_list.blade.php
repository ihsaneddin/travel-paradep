<table class="table" id="routes-list">
  <thead>
    <tr>
      <th>
        Name
      </th>
      <th>
        Code
      </th>
      <th>
        Departure
      </th>
      <th>
        Destination
      </th>
      <th>
        Class
      </th>
      <th>&nbsp</th>
    </tr>
  </thead>
  <tbody>
    @foreach($options['all_routes'] as $route)
      <tr class=" {{ $resource->route_id == $route['id'] ? 'warning' : '' }}">
        <td>{{ $route['name'] }}</td>
        <td>{{ $route['code'] }}</td>
        <td>{{ $route['departure_station'] }}</td>
        <td>{{ $route['destination_station'] }}</td>
        <td><span class="btn btn-xs btn-danger">{{ $route['category']['name'] }} </span></td>
        <td>
          <a href="#" class="select-trip-option" data-target="#route_id" data-value="{{ $route['id'] }}" {{ $resource->route_id == $route['id'] ? 'disabled=""' : '' }}>
            <i class="icon {{ $resource->route_id == $route['id'] ? 'icon-ok' : 'icon-check' }}"></i>
          </a>
        </td>
      </tr>
    @endforeach
  </tbody>
</table>