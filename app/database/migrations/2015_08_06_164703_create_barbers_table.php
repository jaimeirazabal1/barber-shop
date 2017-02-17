<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBarbersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('barbers', function(Blueprint $table)
		{
			$table->increments('id');
            $table->string('first_name', 100);
            $table->string('last_name', 100);
            $table->text('address');
            $table->string('phone', 100);
            $table->string('cellphone', 100);
            $table->string('email');
            $table->string('color', 10);
            $table->string('code', 30)->unique();
            $table->enum('salary_type', ['daily','weekly','biweekly','monthly']);
            $table->integer('salary')->unsigned();
            $table->boolean('active');
            $table->integer('store_id')->unsigned();
            $table->foreign('store_id')->references('id')->on('stores')->onDelete('restrict');
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
		Schema::drop('barbers');
	}

}
