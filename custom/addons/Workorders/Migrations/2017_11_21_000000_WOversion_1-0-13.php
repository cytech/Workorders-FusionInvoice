<?php

use FI\Modules\Settings\Models\Setting;
use Illuminate\Database\Migrations\Migration;

class WOversion1013 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Setting::saveByKey('addonWorkorderStatusFilter', 'all_statuses');
        Setting::saveByKey('addonWorkorderVersion', '1.0.13');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
	    //delete workorder settings
	    DB::table('settings')->where('setting_key', '=', 'addonWorkorderStatusFilter')->delete();
    }
}
