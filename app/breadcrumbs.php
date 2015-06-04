<?php

Breadcrumbs::register('dashboards', function($breadcrumbs) {
    $breadcrumbs->push('Dashboard', route('admin.dashboards.index'),['icon' => 'home.png']);
});
Breadcrumbs::register('master', function($breadcrumbs) {
    $breadcrumbs->parent('dashboards');
    $breadcrumbs->push('Master');
});
Breadcrumbs::register('process', function($breadcrumbs) {
    $breadcrumbs->parent('dashboards');
    $breadcrumbs->push('Process');
});
Breadcrumbs::register('admin.master.users.index', function($breadcrumbs) {
    $breadcrumbs->parent('master');
    $breadcrumbs->push('Users', route('admin.master.users.index'));
});
Breadcrumbs::register('admin.master.users.create', function($breadcrumbs){
	$breadcrumbs->parent('admin.master.users.index');
	$breadcrumbs->push('New', route('admin.master.users.create'));
});
Breadcrumbs::register('admin.master.users.show', function($breadcrumbs,$user){
	$breadcrumbs->parent('admin.master.users.index');
	$breadcrumbs->push($user->username, route('admin.master.users.show'));
});
Breadcrumbs::register('admin.master.users.edit', function($breadcrumbs,$user){
	$breadcrumbs->parent('admin.master.users.index');
	$breadcrumbs->push('Edit '.$user->username, route('admin.master.users.edit'));
});

Breadcrumbs::register('admin.profiles.edit', function($breadcrumbs,$user){
	$breadcrumbs->parent('dashboards');
	$breadcrumbs->push('Edit '.$user->username, route('admin.profile.edit'));
});
Breadcrumbs::register('admin.master.cars.index', function($breadcrumbs) {
    $breadcrumbs->parent('master');
    $breadcrumbs->push('Cars', route('admin.master.cars.index'));
});
Breadcrumbs::register('admin.master.cars.create', function($breadcrumbs){
	$breadcrumbs->parent('admin.master.cars.index');
	$breadcrumbs->push('New', route('admin.master.cars.create'));
});
Breadcrumbs::register('admin.master.cars.edit', function($breadcrumbs,$car){
	$breadcrumbs->parent('admin.master.cars.index');
	$breadcrumbs->push($car->model->name, route('admin.master.cars.edit'));
});
Breadcrumbs::register('admin.master.cars.show', function($breadcrumbs,$car){
	$breadcrumbs->parent('admin.master.cars.index');
	$breadcrumbs->push($car->model->name, route('admin.master.cars.show', array('cars' => $car->id)));
});
Breadcrumbs::register('admin.master.stations.index', function($breadcrumbs) {
    $breadcrumbs->parent('master');
    $breadcrumbs->push('Stations', route('admin.master.stations.index'));
});
Breadcrumbs::register('admin.master.stations.show', function($breadcrumbs,$station) {
    $breadcrumbs->parent('admin.master.stations.index');
    $breadcrumbs->push($station->code, route('admin.master.stations.show',array('stations' => $station)));
});
Breadcrumbs::register('admin.master.stations.create', function($breadcrumbs){
	$breadcrumbs->parent('admin.master.stations.index');
	$breadcrumbs->push('New', route('admin.master.stations.create'));
});
Breadcrumbs::register('admin.master.stations.store', function($breadcrumbs){
	$breadcrumbs->parent('admin.master.stations.index');
	$breadcrumbs->push('New', route('admin.master.stations.create'));
});
Breadcrumbs::register('admin.master.stations.edit', function($breadcrumbs,$station){
	$breadcrumbs->parent('admin.master.stations.index');
	$breadcrumbs->push($station->code, route('admin.master.stations.edit',array('stations' => $station->id)));
});
Breadcrumbs::register('admin.master.stations.update', function($breadcrumbs,$station){
	$breadcrumbs->parent('admin.master.stations.index');
	$breadcrumbs->push($station->code, route('admin.master.stations.edit',array('stations' => $station->id)));
});
Breadcrumbs::register('admin.master.drivers.index', function($breadcrumbs){
	$breadcrumbs->parent('master');
	$breadcrumbs->push('Drivers', route('admin.master.drivers.index'));
});
Breadcrumbs::register('admin.master.drivers.show', function($breadcrumbs,$driver){
	$breadcrumbs->parent('admin.master.drivers.index');
	$breadcrumbs->push($driver->name, route('admin.master.drivers.show',array('drivers' => $driver->id)));
});
Breadcrumbs::register('admin.master.drivers.create', function($breadcrumbs){
	$breadcrumbs->parent('admin.master.drivers.index');
	$breadcrumbs->push("Create", route('admin.master.drivers.create'));
});
Breadcrumbs::register('admin.master.drivers.store', function($breadcrumbs){
	$breadcrumbs->parent('admin.master.drivers.index');
	$breadcrumbs->push("Create", route('admin.master.drivers.create'));
});
Breadcrumbs::register('admin.master.drivers.edit', function($breadcrumbs,$driver){
	$breadcrumbs->parent('admin.master.drivers.index');
	$breadcrumbs->push("Edit ".$driver->code, route('admin.master.drivers.edit',array('drivers'=>$driver->id)));
});
Breadcrumbs::register('admin.master.drivers.update', function($breadcrumbs,$driver){
	$breadcrumbs->parent('admin.master.drivers.index');
	$breadcrumbs->push("Edit ".$driver->code, route('admin.master.drivers.edit',array('drivers'=>$driver->id)));
});
Breadcrumbs::register('admin.master.routes.index', function($breadcrumbs){
	$breadcrumbs->parent('master');
	$breadcrumbs->push('Routes', route('admin.master.routes.index'));
});
Breadcrumbs::register('admin.master.routes.show', function($breadcrumbs,$route){
	$breadcrumbs->parent('admin.master.routes.index');
	$breadcrumbs->push($route->code, route('admin.master.routes.show', array('routes' => $route->id)));
});
Breadcrumbs::register('admin.master.routes.create', function($breadcrumbs){
	$breadcrumbs->parent('admin.master.routes.index');
	$breadcrumbs->push('Create', route('admin.master.routes.create'));
});
Breadcrumbs::register('admin.master.routes.store', function($breadcrumbs){
	$breadcrumbs->parent('admin.master.routes.index');
	$breadcrumbs->push('Create', route('admin.master.routes.create'));
});
Breadcrumbs::register('admin.master.routes.edit', function($breadcrumbs,$route){
	$breadcrumbs->parent('admin.master.routes.index');
	$breadcrumbs->push($route->code, route('admin.master.routes.edit',array('routes' => $route->id)));
});
Breadcrumbs::register('admin.master.routes.update', function($breadcrumbs,$route){
	$breadcrumbs->parent('admin.master.routes.index');
	$breadcrumbs->push($route->code, route('admin.master.routes.edit',array('routes' => $route->id)));
});
Breadcrumbs::register('admin.process.trips.index', function($breadcrumbs){
	$breadcrumbs->parent('process');
	$breadcrumbs->push('Trips', route('admin.process.trips.index'));
});
Breadcrumbs::register('admin.process.trips.show', function($breadcrumbs, $trip){
	$breadcrumbs->parent('admin.process.trips.index');
	$breadcrumbs->push($trip->code, route('admin.process.trips.show', array('trips' => $trip->id)));
});
Breadcrumbs::register('admin.process.trips.create', function($breadcrumbs){
	$breadcrumbs->parent('admin.process.trips.index');
	$breadcrumbs->push('Create', route('admin.process.trips.create'));
});
Breadcrumbs::register('admin.process.trips.store', function($breadcrumbs){
	$breadcrumbs->parent('admin.process.trips.index');
	$breadcrumbs->push('Create', route('admin.process.trips.create'));
});
Breadcrumbs::register('admin.process.trips.edit', function($breadcrumbs, $trip){
	$breadcrumbs->parent('admin.process.trips.index');
	$breadcrumbs->push($trip->code, route('admin.process.trips.edit',array('trips' => $trip->id)));
});
Breadcrumbs::register('admin.process.trips.update', function($breadcrumbs, $trip){
	$breadcrumbs->parent('admin.process.trips.index');
	$breadcrumbs->push($trip->code, route('admin.process.trips.edit',array('trips' => $trip->id)));
});
Breadcrumbs::register('admin.process.bookings.index', function($breadcrumbs){
	$breadcrumbs->parent('process');
	$breadcrumbs->push('Bookings', route('admin.process.bookings.index'));
});
Breadcrumbs::register('admin.process.bookings.show', function($breadcrumbs, $booking){
	$breadcrumbs->parent('admin.process.bookings.index');
	$breadcrumbs->push($booking->code, route('admin.process.bookings.show', array('bookings' => $booking->id)));
});
Breadcrumbs::register('admin.process.trips.bookings.create', function($breadcrumbs, $booking){
	$breadcrumbs->parent('admin.process.trips.index');
	$breadcrumbs->push('Create Booking', route('admin.process.trips.bookings.create', array('trips' => $booking->trip_id, 'bookings' => $booking->id)));
});
Breadcrumbs::register('admin.process.trips.bookings.store', function($breadcrumbs, $booking){
	$breadcrumbs->parent('admin.process.trips.index');
	$breadcrumbs->push('Create Booking', route('admin.process.trips.bookings.create', array('trips' => $booking->trip_id, 'bookings' => $booking->id)));
});
