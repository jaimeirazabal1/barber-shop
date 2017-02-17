<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateServiceTagServiceTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('service_tag_service', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('service_id')->unsigned()->index();
			$table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
			$table->integer('tag_service_id')->unsigned()->index();
			$table->foreign('tag_service_id')->references('id')->on('tag_services')->onDelete('cascade');
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
		Schema::drop('service_tag_service');
	}

}
