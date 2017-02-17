<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddCompanyIdToCommissionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('commissions', function(Blueprint $table)
		{
			$table->integer('company_id')->unsigned()->index()->nullable();
            $table->foreign('company_id')->references('id')->on('commissions')->onDelete('restrict');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('commissions', function(Blueprint $table)
		{
            $table->dropForeign('commissions_company_id_foreign');
			$table->dropColumn('company_id');
		});
	}

}
