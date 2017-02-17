<?php


class CompanyTableSeeder extends Seeder {

    public function run()
	{

        #$faker = Faker\Factory::create();

        /*for($i = 1; $i <= 100; $i++)
        {
            $company = $faker->unique()->company;*/

        $company = Company::create([
            'name' => 'Barber Shop',
            'slug' => 'barber-shop',
            'user_id' => 2
        ]);

        // Usuarios de la empresa
        $company->users()->attach(2);
        $company->users()->attach(3);

        /*Company::create([
            'name' => 'Spinka and Sons',
            'slug' => 'spinka-and-sons',
            'user_id' => null
        ]);

        Company::create([
            'name' => 'Sauer Cruickshank',
            'slug' => 'sauer-cruickshank',
            'user_id' => null
        ]);
        /*}*/

	}

}