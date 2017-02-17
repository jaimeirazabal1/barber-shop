<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddCustomerIdToSalesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('sales', function(Blueprint $table)
		{
            // TODO: la venta puede ser generada para una venta en mostrador o para un cliente en especifico,
            // sirve para reportes posteriores
            $table->integer('customer_id')->unsigned()->nullable();
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('restrict');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('sales', function(Blueprint $table)
		{
            $table->dropForeign('sales_customer_id_foreign');
			$table->dropColumn('customer_id');
		});
	}

}
