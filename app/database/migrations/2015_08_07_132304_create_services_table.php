<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateServicesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('services', function(Blueprint $table)
		{
			$table->increments('id');
            $table->string('name', 150);
            $table->string('code', 30)->nullable();
            $table->integer('price')->unsigned();
            $table->string('image')->nullable();
            $table->boolean('active')->default(true);
            $table->tinyInteger('order')->default(0);
            $table->integer('estimated_time')->unsigned()->default(30);
            $table->integer('company_id')->unsigned();
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('restrict');
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
		Schema::drop('services');
	}

}
