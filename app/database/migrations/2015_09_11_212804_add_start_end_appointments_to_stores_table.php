<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddStartEndAppointmentsToStoresTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('stores', function(Blueprint $table)
		{
			$table->time('start_appointments');
            $table->time('end_appointments');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('stores', function(Blueprint $table)
		{
			$table->dropColumn('start_appointments');
            $table->dropColumn('end_appointments');
		});
	}

}
