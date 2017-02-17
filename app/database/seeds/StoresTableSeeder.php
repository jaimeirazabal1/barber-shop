<?php

use Faker\Factory as Faker;

class StoresTableSeeder extends Seeder {

	public function run()
	{
		/*$faker = Faker::create();

		foreach(range(1, 100) as $index)
		{
            $storeName = $faker->city;
            $storeAddress = $faker->address;*/

			Store::create([
                'name' => 'Providencia',
                'slug' => Str::slug('Providencia'),
                'address' => 'Providencia 2000',
                'formatted_address' => 'Providencia 2000',
                'phone' => '3030303030',
                'email' => ('providencia@barberiapp.dev'),
                'lat'   => '2.900',
                'lng'   => '2.900',
                'is_matrix' => true,
                'active' => true,
                'order' => 0,
                'tolerance_time' => 0,
                'company_id' => 1,
                'user_id' => 3
			]);

		/*}*/
	}

}