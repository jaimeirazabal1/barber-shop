<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddInitialRegisterToCashoutsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('cashouts', function(Blueprint $table)
		{
			$table->integer('initial_register')->default(0);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('cashouts', function(Blueprint $table)
		{
			$table->dropColumn('initial_register');
		});
	}

}
