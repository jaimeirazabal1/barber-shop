<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddTypeToSalesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('sales', function(Blueprint $table)
		{
			$table->enum('type', ['cash', 'card', 'oxxo', 'deposit', 'transfer']);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('sales', function(Blueprint $table)
		{
			$table->dropColumn('type');
		});
	}

}
