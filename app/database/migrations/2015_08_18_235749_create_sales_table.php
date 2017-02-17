<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSalesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sales', function(Blueprint $table)
		{
			$table->increments('id');
            $table->datetime('checkin');
            $table->text('comments')->nullable();
            $table->enum('status', ['pending', 'paid', 'canceled'])->default('pending');
            $table->integer('appointment_id')->unsigned()->nullable();
            $table->foreign('appointment_id')->references('id')->on('appointments')->onDelete('restrict');
            $table->integer('total')->unsigned()->default(0);// TODO : debe de ser calculado automáticamente
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('sales');
	}

}
