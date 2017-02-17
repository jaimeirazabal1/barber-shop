<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;

class CustomersTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker::create();

        $company = Company::find(1);

		foreach(range(1, 5) as $index)
		{
            $name = $faker->firstName;

			$customer = Customer::create([
                'first_name' => $name,
                'last_name' => $faker->lastName,
                'aka' => ($faker->boolean(50)) ? $name : null,
                'birthdate' => $faker->dateTime,
                'email' => $faker->email,
                'phone' => $faker->phoneNumber,
                'cellphone' => $faker->phoneNumber,
                'notes' => $faker->paragraph(2, true),
                'barber_id' => $faker->numberBetween(1,3),
                'user_id' => null,
                'company_id' => 1,
			]);
		}
	}

}