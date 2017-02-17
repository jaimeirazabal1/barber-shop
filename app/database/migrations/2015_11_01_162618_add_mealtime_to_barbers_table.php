<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddMealtimeToBarbersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('barbers', function(Blueprint $table)
		{
			$table->time('mealtime_in');
            $table->time('mealtime_out');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('barbers', function(Blueprint $table)
		{
			$table->dropColumn('mealtime_in');
            $table->dropColumn('mealtime_out');
		});
	}

}
