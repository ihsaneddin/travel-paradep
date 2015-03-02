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

		$this->call('RoleTableSeeder');
		$this->call('UserTableSeeder');
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
