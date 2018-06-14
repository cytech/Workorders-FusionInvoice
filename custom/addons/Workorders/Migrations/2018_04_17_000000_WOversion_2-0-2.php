<?php

use FI\Modules\Settings\Models\Setting;
use Illuminate\Database\Migrations\Migration;

class WOversion202 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    DB::table('workorder_settings')->where('setting_key','version')->update([ 'setting_value' => '2.0.2']);
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
