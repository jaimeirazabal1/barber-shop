<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddCategoryFieldToServicesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('services', function(Blueprint $table)
		{
            $table->integer('category_id')->unsigned()->nullable()->index();
            $table->foreign('category_id')->references('id')->on('category_services')->onDelete('restrict');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('services', function(Blueprint $table)
		{
			$table->dropForeign('services_category_id_foreign');
            $table->dropColumn('category_id');
		});
	}

}
