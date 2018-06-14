<?php

use FI\Modules\Settings\Models\Setting;
use Illuminate\Database\Migrations\Migration;

class WOversion1014 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Setting::saveByKey('addonWorkorderVersion', '1.0.14');

	    //insert workorder settings for timesheet
	    DB::table('settings')->insert(array('setting_key' => 'addonWorkorderTSCompanyName','setting_value' => 'YOURQBCOMPANYNAME'));
	    DB::table('settings')->insert(array('setting_key' => 'addonWorkorderTSCompanyCreate','setting_value' => 'YOURQBCOMPANYCREATETIME'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
	    //delete workorder settings
	    DB::table('settings')->where('setting_key', '=', 'addonWorkorderTSCompanyName')->delete();
	    DB::table('settings')->where('setting_key', '=', 'addonWorkorderTSCompanyCreate')->delete();
    }
}
