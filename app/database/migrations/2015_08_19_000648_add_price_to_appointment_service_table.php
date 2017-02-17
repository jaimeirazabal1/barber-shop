<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddPriceToAppointmentServiceTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('appointment_service', function(Blueprint $table)
		{
            $table->integer('price')->unsigned()->default(0);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('appointment_service', function(Blueprint $table)
		{
			$table->dropColumn('price');
		});
	}

}
