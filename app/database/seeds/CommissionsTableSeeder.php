<?php


class CommissionsTableSeeder extends Seeder {

	public function run()
	{
        Commission::create([
            'min' => 0,
            'max' => (6999 * 100),
            'percent' => 15
        ]);
        Commission::create([
            'min' => (7000 * 100),
            'max' => (7999 * 100),
            'percent' => 17
        ]);
        Commission::create([
            'min' => (8000 * 100),
            'max' => (8999 * 100),
            'percent' => 19
        ]);
        Commission::create([
            'min' => (9000 * 100),
            'max' => (9999 * 100),
            'percent' => 21
        ]);
        Commission::create([
            'min' => (10000 * 100),
            'max' => (11999 * 100),
            'percent' => 22
        ]);
        Commission::create([
            'min' => (12000 * 100),
            'max' => (14999 * 100),
            'percent' => 24
        ]);
        Commission::create([
            'min' => (15000 * 100),
            'max' => (15999 * 100),
            'percent' => 28
        ]);
        Commission::create([
            'min' => (16000 * 100),
            'max' => null,
            'percent' => 30
        ]);
    }

}