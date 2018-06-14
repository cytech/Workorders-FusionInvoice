<?php

use FI\Modules\Settings\Models\Setting;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class WOversion200 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::create(strtolower('workorder_settings'), function (Blueprint $table) {
		    $table->increments('id');
		    $table->timestamps();
		    $table->string('setting_key');
		    $table->text('setting_value');

		    $table->index('setting_key');

	    });

	    //get existing settings from FI settings
	    $scheduler = Setting::where('setting_key', 'addonWorkorderScheduler')->first()->setting_value;
	    $restolup = Setting::where('setting_key', 'addonWorkorderRestolup')->first()->setting_value;
	    $emptolup = Setting::where('setting_key', 'addonWorkorderEmptolup')->first()->setting_value;
	    $workorderTemplate = Setting::where('setting_key', 'addonWorkorderworkorderTemplate')->first()->setting_value;
	    $workorderGroup = Setting::where('setting_key', 'addonWorkorderworkorderGroup')->first()->setting_value;
	    $workorderExpires = Setting::where('setting_key', 'addonWorkorderworkorderExpires')->first()->setting_value;
	    $workorderTerms = Setting::where('setting_key', 'addonWorkorderworkorderTerms')->first()->setting_value;
	    $workorderFooter = Setting::where('setting_key', 'addonWorkorderworkorderFooter')->first()->setting_value;
	    $convertWorkorderTerms = Setting::where('setting_key', 'addonWorkorderconvertWorkorderTerms')->first()->setting_value;
	    $enableLegacyCalendar = Setting::where('setting_key', 'addonWorkorderEnableLegacyCalendar')->first()->setting_value;
	    $legacyCalendarScript = Setting::where('setting_key', 'addonWorkorderLegacyCalendarScript')->first()->setting_value;
	    $tsCompanyName = Setting::where('setting_key', 'addonWorkorderTSCompanyName')->first()->setting_value;
	    $tsCompanyCreate = Setting::where('setting_key', 'addonWorkorderTSCompanyCreate')->first()->setting_value;
	    $statusFilter = Setting::where('setting_key', 'addonWorkorderStatusFilter')->first()->setting_value;

	    //insert workorder workorder_settings
	    DB::table('workorder_settings')->insert([ 'setting_key' => 'scheduler', 'setting_value' => $scheduler ]);
	    DB::table('workorder_settings')->insert([ 'setting_key' => 'restolup', 'setting_value' => $restolup ]);
	    DB::table('workorder_settings')->insert([ 'setting_key' => 'emptolup', 'setting_value' => $emptolup ]);
	    DB::table('workorder_settings')->insert([ 'setting_key' => 'workorderTemplate', 'setting_value' => $workorderTemplate ]);
	    DB::table('workorder_settings')->insert([ 'setting_key' => 'workorderGroup', 'setting_value' => $workorderGroup ]);
	    DB::table('workorder_settings')->insert([ 'setting_key' => 'workorderExpires', 'setting_value' => $workorderExpires ]);
	    DB::table('workorder_settings')->insert([ 'setting_key' => 'workorderTerms', 'setting_value' => $workorderTerms ]);
	    DB::table('workorder_settings')->insert([ 'setting_key' => 'workorderFooter', 'setting_value' => $workorderFooter ]);
	    DB::table('workorder_settings')->insert([ 'setting_key' => 'convertWorkorderTerms', 'setting_value' => $convertWorkorderTerms ]);
	    DB::table('workorder_settings')->insert([ 'setting_key' => 'enableLegacyCalendar', 'setting_value' => $enableLegacyCalendar ]);
	    DB::table('workorder_settings')->insert([ 'setting_key' => 'legacyCalendarScript', 'setting_value' => $legacyCalendarScript ]);
	    DB::table('workorder_settings')->insert([ 'setting_key' => 'version', 'setting_value' => '2.0.0' ]);
	    //insert workorder settings for timesheet
	    DB::table('workorder_settings')->insert([ 'setting_key' => 'tsCompanyName', 'setting_value' => $tsCompanyName ]);
	    DB::table('workorder_settings')->insert([ 'setting_key' => 'tsCompanyCreate', 'setting_value' => $tsCompanyCreate ]);
	    //statusFilter
	    DB::table('workorder_settings')->insert([ 'setting_key' => 'statusFilter', 'setting_value' => $statusFilter ]);

	    //remove old settings from FI settings
	    DB::table('settings')->where('setting_key', 'like','addonWorkorder%')->delete();

	    //rename employees and resources tables
	    Schema::rename('employees','workorder_employees');
	    Schema::rename('resources','workorder_resources');

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
	    Schema::rename('workorder_employees','employees');
	    Schema::rename('workorder_resources','resources');
	    Schema::dropIfExists(strtolower('workorder_settings'));

    }
}
