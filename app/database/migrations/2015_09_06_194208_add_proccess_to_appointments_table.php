<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddProccessToAppointmentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('appointments', function(Blueprint $table)
		{
            DB::statement("ALTER TABLE appointments CHANGE COLUMN status status ENUM('confirmed','completed','canceled','pending', 'process')");
        });
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('appointments', function(Blueprint $table)
		{
			
		});
	}

}
