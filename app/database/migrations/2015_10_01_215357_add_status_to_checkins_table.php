<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddStatusToCheckinsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('checkins', function(Blueprint $table)
		{
			$table->enum('status', ['present', 'absence', 'retardment', 'excused_absence', 'vacation']);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('checkins', function(Blueprint $table)
		{
			$table->dropColumn('status');
		});
	}

}
