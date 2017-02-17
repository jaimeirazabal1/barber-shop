<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductSaleTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('product_sale', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('price')->unsigned()->default(0);
            $table->integer('quantity')->unsigned()->default(1);
			$table->integer('product_id')->unsigned()->index();
			$table->foreign('product_id')->references('id')->on('products')->onDelete('restrict');
			$table->integer('sale_id')->unsigned()->index();
			$table->foreign('sale_id')->references('id')->on('sales')->onDelete('restrict');
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
		Schema::drop('product_sale');
	}

}
