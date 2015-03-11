<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		DB::statement('
			SET FOREIGN_KEY_CHECKS = 0
		');
		$this->call('RoleTableSeeder');
		$this->call('UserTableSeeder');
		$this->call('CarTableSeeder');
		$this->call('CategoryTableSeeder');
		DB::statement('
			SET FOREIGN_KEY_CHECKS = 1
		');
	}

}

class RoleTableSeeder extends Seeder{
	public function run()
	{
		DB::table('roles')->truncate();		
		$role_arr = ['name' => 'super_admin', 'description' => 'God of the arena'];
		$role = new Role;
		$role->fill($role_arr);
		$role->save();
		Role::insert([['name' => 'management', 'description' => 'Management'],['name' => 'station_operator', 'description' => 'Station Operator'],['name' => 'pool_operator', 'description' => 'Pool Operator']]);
	}
}

class UserTableSeeder extends Seeder
{ 
	public function run()
	{
		DB::table('users')->truncate();
        $user_arr = ['username' => 'admin','email' => 'admin@paradep.com', 'password' => 'password', 'password_confirmation' => 'password', 'confirmed' => 1, 'role_ids' => '1'];
        $repo = App::make('UserRepository');
        $user = $repo->signup($user_arr);
	}
}

class CarTableSeeder extends Seeder
{
	public function run()
	{
		DB::table('cars')->truncate();
		$cars = array(
			'toyota' => array('avanza', 'rush'),
			'jaguar' => array('x-ls'),
			'audi' => array('sx-1'),
			'bmw' => array('slr'),
			'ford' => array('monster')
			);
		foreach ($cars as $manufacture => $cars) {
			foreach ($cars as $carName) {
				Car::create(array('name' => $carName, 'manufacture' => $manufacture));
			}
		}

	}
}

class CategoryTableSeeder extends Seeder
{
	public function run()
	{
		DB::table('categories')->truncate();
		$categories = [ 'car' => ['economy', 'business', 'executive']];
		foreach ($categories as $car => $classes) {
			foreach ($classes as $class) {
				Category::create(['for' => $car, 'name' => $class]);
			}	
		}
	}
}
