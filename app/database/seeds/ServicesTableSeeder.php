<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;

class ServicesTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker::create();

		foreach(range(1, 1) as $index)
		{
            if ( $faker->boolean(90))
            {
                Service::create([
                    'name' => 'Corte Caballero',
                    'code' => Str::random(10),
                    'price' => (($faker->randomDigit * 100) * 100),
                    'image' => '',
                    'active' => $faker->boolean(50),
                    'order' => $faker->numberBetween(0,100),
                    'estimated_time' => 30,
                    'company_id' => $index
                ]);
            }
            if ( $faker->boolean(90))
            {
                Service::create([
                    'name' => 'Corte niño',
                    'code' => Str::random(10),
                    'price' => (($faker->randomDigit * 100) * 100),
                    'image' => '',
                    'active' => $faker->boolean(50),
                    'order' => $faker->numberBetween(0,100),
                    'estimated_time' => 30,
                    'company_id' => $index
                ]);
            }
            if ( $faker->boolean(90))
            {
                Service::create([
                    'name' => 'Tinte de Canas en Cabello',
                    'code' => Str::random(10),
                    'price' => (($faker->randomDigit * 100) * 100),
                    'image' => '',
                    'active' => $faker->boolean(50),
                    'order' => $faker->numberBetween(0,100),
                    'estimated_time' => 30,
                    'company_id' => $index
                ]);
            }
            if ( $faker->boolean(90))
            {
                Service::create([
                    'name' => 'Tinte de Canas en Barba',
                    'code' => Str::random(10),
                    'price' => (($faker->randomDigit * 100) * 100),
                    'image' => '',
                    'active' => $faker->boolean(50),
                    'order' => $faker->numberBetween(0,100),
                    'estimated_time' => 30,
                    'company_id' => $index
                ]);
            }
            if ( $faker->boolean(90))
            {
                Service::create([
                    'name' => 'Afeitado de Craneo clásico',
                    'code' => Str::random(10),
                    'price' => (($faker->randomDigit * 100) * 100),
                    'image' => '',
                    'active' => $faker->boolean(50),
                    'order' => $faker->numberBetween(0,100),
                    'estimated_time' => 30,
                    'company_id' => $index
                ]);
            }
            if ( $faker->boolean(90))
            {
                Service::create([
                    'name' => 'Afeitado de Craneo MN',
                    'code' => Str::random(10),
                    'price' => (($faker->randomDigit * 100) * 100),
                    'image' => '',
                    'active' => $faker->boolean(50),
                    'order' => $faker->numberBetween(0,100),
                    'estimated_time' => 30,
                    'company_id' => $index
                ]);
            }
            if ( $faker->boolean(90))
            {
                Service::create([
                    'name' => 'Afeitada clásica',
                    'code' => Str::random(10),
                    'price' => (($faker->randomDigit * 100) * 100),
                    'image' => '',
                    'active' => $faker->boolean(50),
                    'order' => $faker->numberBetween(0,100),
                    'estimated_time' => 30,
                    'company_id' => $index
                ]);
            }
            if ( $faker->boolean(90))
            {
                Service::create([
                    'name' => 'Afeitada MN',
                    'code' => Str::random(10),
                    'price' => (($faker->randomDigit * 100) * 100),
                    'image' => '',
                    'active' => $faker->boolean(50),
                    'order' => $faker->numberBetween(0,100),
                    'estimated_time' => 30,
                    'company_id' => $index
                ]);
            }
            if ( $faker->boolean(90))
            {
                Service::create([
                    'name' => 'Corte de Cabello y Afeitado clásico',
                    'code' => Str::random(10),
                    'price' => (($faker->randomDigit * 100) * 100),
                    'image' => '',
                    'active' => $faker->boolean(50),
                    'order' => $faker->numberBetween(0,100),
                    'estimated_time' => 30,
                    'company_id' => $index
                ]);
            }
            if ( $faker->boolean(90))
            {
                Service::create([
                    'name' => 'Corte de cabello y arreglado de barba',
                    'code' => Str::random(10),
                    'price' => (($faker->randomDigit * 100) * 100),
                    'image' => '',
                    'active' => $faker->boolean(50),
                    'order' => $faker->numberBetween(0,100),
                    'estimated_time' => 30,
                    'company_id' => $index
                ]);
            }
            if ( $faker->boolean(90))
            {
                Service::create([
                    'name' => 'Afeitado de cabeza clásico y afeitado clásico',
                    'code' => Str::random(10),
                    'price' => (($faker->randomDigit * 100) * 100),
                    'image' => '',
                    'active' => $faker->boolean(50),
                    'order' => $faker->numberBetween(0,100),
                    'estimated_time' => 30,
                    'company_id' => $index
                ]);
            }
            if ( $faker->boolean(90))
            {
                Service::create([
                    'name' => 'Afeitado de cabeza clásico y arreglo de barba',
                    'code' => Str::random(10),
                    'price' => (($faker->randomDigit * 100) * 100),
                    'image' => '',
                    'active' => $faker->boolean(50),
                    'order' => $faker->numberBetween(0,100),
                    'estimated_time' => 30,
                    'company_id' => $index
                ]);
            }
            if ( $faker->boolean(90))
            {
                Service::create([
                    'name' => 'Arreglo de barba',
                    'code' => Str::random(10),
                    'price' => (($faker->randomDigit * 100) * 100),
                    'image' => '',
                    'active' => $faker->boolean(50),
                    'order' => $faker->numberBetween(0,100),
                    'estimated_time' => 30,
                    'company_id' => $index
                ]);
            }
            if ( $faker->boolean(90))
            {
                Service::create([
                    'name' => 'Arreglo de Barba MN',
                    'code' => Str::random(10),
                    'price' => (($faker->randomDigit * 100) * 100),
                    'image' => '',
                    'active' => $faker->boolean(50),
                    'order' => $faker->numberBetween(0,100),
                    'estimated_time' => 30,
                    'company_id' => $index
                ]);
            }
            if ( $faker->boolean(90))
            {
                Service::create([
                    'name' => 'Arreglo de Bigote y Patilla',
                    'code' => Str::random(10),
                    'price' => (($faker->randomDigit * 100) * 100),
                    'image' => '',
                    'active' => $faker->boolean(50),
                    'order' => $faker->numberBetween(0,100),
                    'estimated_time' => 30,
                    'company_id' => $index
                ]);
            }


		}
	}

}