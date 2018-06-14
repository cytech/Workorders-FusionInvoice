<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class WorkordersAddforeign extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    DB::statement('SET FOREIGN_KEY_CHECKS=0');

    	//add softdelete to workorder
	    Schema::table('workorders', function (Blueprint $table) {
		    $table->softDeletes();
	    });

	    //add foreign keys to workorders: amounts,  items, item amounts, custom, tax rates
	    Schema::table('workorder_amounts', function (Blueprint $table) {
	    	$table->integer('workorder_id')->unsigned()->change();
		    $table->foreign('workorder_id')->references('id')->on('workorders')->onUpdate('cascade')->onDelete('cascade');
	    });
	    Schema::table('workorder_items', function (Blueprint $table) {
		    $table->integer('workorder_id')->unsigned()->change();
		    $table->foreign('workorder_id')->references('id')->on('workorders')->onUpdate('cascade')->onDelete('cascade');
	    });
	    Schema::table('workorder_item_amounts', function (Blueprint $table) {
		    $table->integer('item_id')->unsigned()->change();
		    $table->foreign('item_id')->references('id')->on('workorder_items')->onUpdate('cascade')->onDelete('cascade');
	    });
	    Schema::table('workorders_custom', function (Blueprint $table) {
		    $table->integer('workorder_id')->unsigned()->change();
		    //$table->primary('workorder_id');
		    $table->foreign('workorder_id')->references('id')->on('workorders')->onUpdate('cascade')->onDelete('cascade');
	    });
	    Schema::table('workorder_tax_rates', function (Blueprint $table) {
		    $table->integer('workorder_id')->unsigned()->change();
		    $table->foreign('workorder_id')->references('id')->on('workorders')->onUpdate('cascade')->onDelete('cascade');
	    });


	    //add foreign keys to workorder_items: for resource_table resource_id

	    DB::statement('SET FOREIGN_KEY_CHECKS=1');

	    //clear view cache or else weird error after install
	    //Artisan::call('view:clear');
	    deleteTempFiles();
	    deleteViewCache();

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
	    DB::statement('SET FOREIGN_KEY_CHECKS=0');
	    Schema::table('workorder_amounts', function (Blueprint $table){
		    $table->dropForeign('workorder_amounts_workorder_id_foreign');
	    });

	    Schema::table('workorder_items', function (Blueprint $table){
		    $table->dropForeign('workorder_items_workorder_id_foreign');
	    });

	    Schema::table('workorder_item_amounts', function (Blueprint $table){
		    $table->dropForeign('workorder_item_amounts_item_id_foreign');
	    });

	    Schema::table('workorders_custom', function (Blueprint $table){
		    $table->dropForeign('workorders_custom_workorder_id_foreign');
	    });

	    Schema::table('workorder_tax_rates', function (Blueprint $table){
		    $table->dropForeign('workorder_tax_rates_workorder_id_foreign');
	    });
	    DB::statement('SET FOREIGN_KEY_CHECKS=1');

    }
}
