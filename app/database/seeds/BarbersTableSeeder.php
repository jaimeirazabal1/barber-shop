<?php

use Faker\Factory as Faker;

class BarbersTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker::create();

        $company = 1;
        $store   = Store::find($company);

		foreach(range(1, 3) as $index)
		{
			Barber::create([
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'address' => $faker->address,
                'phone' => $faker->phoneNumber,
                'cellphone' => $faker->phoneNumber,
                'email' => $faker->email,
                'color' => $faker->hexColor,
                'code' => $faker->unique()->randomKey(['1','2','3','4','5','6','7','8','9','0','a','b','c','d','e','f']),
                'salary_type' => 'weekly',
                'salary' => ($faker->numberBetween(1,10) * 1000),
                'active' => $faker->boolean(70),
                'store_id' => $store->id,
                'company_id' => $store->company_id
			]);
		}
	}

}