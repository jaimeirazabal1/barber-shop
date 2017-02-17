<?php

class UserTableSeeder extends Seeder {

	public function run()
	{
        // Crea el grupo
        $adminGroup = Sentry::createGroup(array(
            'name'        => 'Administrador',
            'permissions' => array(
                'admin' => 1,
            ),
        ));

        $companyGroup = Sentry::createGroup(array(
            'name'        => 'Empresa',
            'permissions' => array(
                'company' => 1,
            ),
        ));

        $storeGroup = Sentry::createGroup(array(
            'name'        => 'Sucursal',
            'permissions' => array(
                'store' => 1,
            ),
        ));

        $customerGroup = Sentry::createGroup(array(
            'name'        => 'Cliente',
            'permissions' => array(
                'customer' => 1,
            ),
        ));

        $barbersGroup = Sentry::createGroup(array(
            'name'        => 'Barbero',
            'permissions' => array(
                'barber' => 1,
            ),
        ));


        // Crea el usuario
        $admin = Sentry::createUser(array(
            'first_name' => 'Barberia',
            'last_name'  => 'Admin',
            'email'     => 'diego.h.glez@gmail.com',
            'password'  => 'admin',
            'activated' => true,
        ));
        // Crea el usuario
        $company = Sentry::createUser(array(
            'first_name' => 'Barberia',
            'last_name'  => 'Empresa',
            'email'     => 'admin@barberiapp.dev',
            'password'  => 'company',
            'activated' => true,
        ));
        $store = Sentry::createUser(array(
            'first_name' => 'Barberia',
            'last_name'  => 'Sucursal',
            'email'     => 'providencia@barberiapp.dev',
            'password'  => 'store',
            'activated' => true,
        ));



        // Find the group using the group id
        $companyGroup = Sentry::findGroupById(2);
        $storeGroup = Sentry::findGroupById(3);
        $adminGroup = Sentry::findGroupById(1);

        // Assign the group to the user
        $admin->addGroup($adminGroup);
        $company->addGroup($companyGroup);
        $store->addGroup($storeGroup);


        /*$faker = Faker\Factory::create();

        for($i = 1; $i <= 100; $i++)
        {
            $customer = Sentry::createUser(array(
                'first_name' => $faker->name,
                'last_name'  => 'Cliente',
                'email'     => $faker->unique()->email,
                'password'  => 'customer',
                'activated' => true,
            ));

            $customer->addGroup($customerGroup);
        }*/
	}

}