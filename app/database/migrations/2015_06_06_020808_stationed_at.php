<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class StationedAt extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('stationed_at', function($table)
		{
			$table->increments('id');
			$table->integer('stationable_id')->unsigned();
			$table->string('stationable_type',50);
			$table->integer('station_id')->unsigned();
			$table->string('state');
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
		Schema::drop('stationed_at');
	}

}
