<?php

use Addons\Workorders\Models\Workorder;
use Illuminate\Database\Migrations\Migration;

class WOCompanyProfilesCreate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Workorder::query()->update(['company_profile_id' => 1]);
	    //2018-02-16 had to replace above due to fail when Workorder Model was changed
        DB::raw(" update `workorders` set `company_profile_id` = 1, `updated_at` = now() ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
