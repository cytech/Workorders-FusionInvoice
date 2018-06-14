<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class WoDiscount extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('workorders', function(Blueprint $table)
        {
            $table->decimal('discount', 15, 2)->default(0.00)->after('viewed');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('workorders', function(Blueprint $table)
        {
            $table->dropColumn('discount');
        });
    }
}
