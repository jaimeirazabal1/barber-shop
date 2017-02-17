<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddTypeToCheckinsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('checkins', function(Blueprint $table)
		{
            $table->enum('type', ['check_in', 'mealtime_start', 'mealtime_over', 'check_out']);
            # Entrada a laborar
            # Inicio hora de comida
            # Fin hora de comida
            # Salida de laborar
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
			$table->dropColumn('type');
		});
	}

}
