<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddCheckinTimeToBarbersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('barbers', function(Blueprint $table)
		{
			$table->time('check_in');
            $table->time('check_out');
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
			$table->dropColumn('check_in');
            $table->dropColumn('check_out');
		});
	}

}
