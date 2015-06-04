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
			$table->date('departure_date');
			$table->time('departure_hour');
			$table->date('arrival_date');
			$table->time('arrival_hour');
			$table->integer('quota')->unsigned();
			$table->string('durations', 50);
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
