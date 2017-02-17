<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCashoutsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cashouts', function(Blueprint $table)
		{
			$table->increments('id');
			$table->datetime('start');
			$table->datetime('end');
			$table->integer('money_on_cash')->unsigned()->default(0);
			$table->integer('money_on_card')->unsigned()->default(0);
			$table->integer('withdraw')->unsigned()->default(0);
			$table->integer('cash_left_on_register')->unsigned()->default(0);
            $table->integer('store_id')->unsigned()->index();
            $table->foreign('store_id')->references('id')->on('stores')->onDelete('restrict');
            $table->integer('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict');
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
		Schema::drop('cashouts');
	}

}
