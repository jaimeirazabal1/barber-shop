<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAppointmentServiceTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('appointment_service', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('estimated_time')->unsigned()->default(30);
			$table->integer('appointment_id')->unsigned()->index();
			$table->foreign('appointment_id')->references('id')->on('appointments')->onDelete('cascade');
			$table->integer('service_id')->unsigned()->index();
			$table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
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
		Schema::drop('appointment_service');
	}

}
