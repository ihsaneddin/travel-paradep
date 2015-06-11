<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookinsgsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('bookings', function($table)
		{
			$table->increments('id');
			$table->integer('passenger_id')->unsigned();
			$table->integer('trip_id')->unsigned();
			$table->string('code');
			$table->integer('seat_no')->unsigned();
			$table->boolean('paid')->default(false);
			$table->string('state', 15)->nullable();
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
		Schema::drop('bookings');
	}

}
