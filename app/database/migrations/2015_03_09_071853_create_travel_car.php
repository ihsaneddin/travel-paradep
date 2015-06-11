<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTravelCar extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('travel_cars', function($table)
		{
			$table->increments('id');
			$table->string('code', 50);
			$table->integer('car_id')->unsigned();
			$table->foreign('car_id')->references('id')->on('cars');
			$table->integer('category_id')->unsigned();
			$table->foreign('category_id')->references('id')->on('categories');
			$table->string('license_no',20)->unique();
			$table->string('stnk_no',50)->unique();
			$table->string('bpkb_no',50)->unique();
			$table->integer('owner_id')->unsigned();
			$table->integer('seat')->unsigned();
			$table->string('state',50)->nullable();
			$table->time('trip_hours');
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
		Schema::drop('travel_cars');
	}

}
