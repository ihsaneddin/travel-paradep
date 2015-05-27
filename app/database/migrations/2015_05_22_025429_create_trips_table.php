<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTripsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('trips', function($table)
		{
			$table->increments('id');
			$table->string('code');
			$table->integer('route_id')->unsigned();
			$table->integer('driver_id')->unsigned()->nullable();
			$table->integer('travel_car_id')->unsigned()->nullable();
			$table->dateTime('departure_time');
			$table->dateTime('arrival_time');
			$table->float('durations');
			$table->string('state', 100)->nullable();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('trips');
	}

}
