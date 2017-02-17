<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCustomerServiceTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('customer_service', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('estimated_time')->unsigned()->default(30);
			$table->integer('customer_id')->unsigned()->index();
			$table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
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
		Schema::drop('customer_service');
	}

}
