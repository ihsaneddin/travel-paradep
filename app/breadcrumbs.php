<?php

Breadcrumbs::register('dashboards', function($breadcrumbs) {
    $breadcrumbs->push('Dashboard', route('admin.dashboards.index'),['icon' => 'home.png']);
});
Breadcrumbs::register('master', function($breadcrumbs) {
    $breadcrumbs->parent('dashboards');
    $breadcrumbs->push('Master');
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
