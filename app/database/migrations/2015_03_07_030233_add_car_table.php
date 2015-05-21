<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCarTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{

	   Schema::create('cars', function($table){
	   		$table->increments('id');
	   		$table->string('name', 100)->unique();
	   		$table->string('manufacture',100);
	   });

	   Schema::create('addresses', function($table){
	   		$table->increments('id');
	   		$table->string('name')->nullable();
	   		$table->string('city',100)->nullable();
	   		$table->string('state',50)->nullable();
	   		$table->integer('addressable_id')->unsigned()->nullable();
	   		$table->string('addressable_type',50)->nullable();
	   		$table->timestamps();
	   });

	   Schema::create('stations', function($table){
	   		$table->increments('id');
	   		$table->string('name',50)->unique();
	   		$table->string('state', 50)->nullable();
	   		$table->timestamps();
	   });

	   Schema::create('categories', function($table){
	   		$table->increments('id');
	   		$table->string('name',50);
	   		$table->string('for',50)->nullable();
	   });

	   Schema::table('attachments', function(Blueprint $table){
	   		$table->integer('attachable_id')->unsigned()->nullable();
	   		$table->string('attachable_type')->nullable();
	   });

	   Schema::create('car_stations',function($table){
	   		$table->increments('id');
	   		$table->integer('car_id');
	   		$table->integer('station_id');
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
		Schema::drop('cars');
		Schema::drop('stations');
		Schema::drop('addresses');
		Schema::drop('categories');
		Schema::drop('car_stations');
		Schema::table('attachments', function(Blueprint $table){
			$table->dropColumn('attachable_id');
			$table->dropColumn('attachable_type');
		});
	}

}
