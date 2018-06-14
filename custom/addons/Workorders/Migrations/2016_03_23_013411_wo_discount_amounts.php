<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class WoDiscountAmounts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('workorder_amounts', function(Blueprint $table)
        {
            $table->decimal('discount', 15, 2)->default(0.00)->after('subtotal');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       
        Schema::table('workorder_amounts', function(Blueprint $table)
        {
            $table->dropColumn('discount');
        });
    }
}
