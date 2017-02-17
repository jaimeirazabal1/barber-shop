<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateStoresTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('stores', function(Blueprint $table)
		{
			$table->increments('id');
            $table->string('name', 150);
            $table->string('slug')->unique();
            $table->text('address');
            $table->string('formatted_address');
            $table->text('phone')->nullable();
            $table->text('email')->nullable();
            $table->float('lat', 10, 6);
            $table->float('lng', 10, 6);
            $table->boolean('is_matrix')->default(false);
            $table->boolean('active')->default(true);
            $table->tinyInteger('order')->default(0);
            $table->integer('tolerance_time')->default(0);
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
		Schema::drop('stores');
	}

}
