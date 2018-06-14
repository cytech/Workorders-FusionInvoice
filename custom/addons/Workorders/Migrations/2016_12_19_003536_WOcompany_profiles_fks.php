<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class WOCompanyProfilesFks extends Migration
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
            $table->integer('company_profile_id');

            $table->index('company_profile_id');
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
            $table->dropColumn('company_profile_id');
        });

    }
}
