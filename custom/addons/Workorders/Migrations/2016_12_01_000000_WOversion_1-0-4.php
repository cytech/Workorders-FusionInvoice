<?php

use FI\Modules\Settings\Models\Setting;
use Illuminate\Database\Migrations\Migration;

class WOversion104 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Setting::saveByKey('addonWorkorderVersion', '1.0.4');
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
