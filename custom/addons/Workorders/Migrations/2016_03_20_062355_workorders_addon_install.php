<?php

/**
 * This file is part of Workorders Addon for FusionInvoice.
 * (c) Cytech <cytech@cytech-eng.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class WorkordersAddonInstall extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workorders', function (Blueprint $table)
        {
            $table->increments('id');
            $table->timestamps();
            $table->integer('invoice_id')->default('0');
            $table->integer('user_id');
            $table->integer('client_id');
            $table->integer('group_id');
            $table->integer('workorder_status_id');
            $table->date('expires_at');
            $table->string('number');
            $table->text('footer')->nullable();
            $table->string('url_key');
            $table->string('currency_code')->nullable();
            $table->decimal('exchange_rate', 10, 7)->default('1');
            $table->text('terms')->nullable();
            $table->string('template')->nullable();
            $table->string('summary', 500)->nullable();
            $table->boolean('viewed')->default(0);
            $table->date('job_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->boolean('will_call');

            $table->index('user_id');
            $table->index('client_id');
            $table->index('group_id');
            $table->index('number');
        });

        Schema::create('workorders_custom', function (Blueprint $table)
        {
            $table->integer('workorder_id');
            $table->timestamps();

            $table->primary('workorder_id');
        });

        Schema::create('workorder_amounts', function (Blueprint $table)
        {
            $table->increments('id');
            $table->timestamps();
            $table->integer('workorder_id');
            $table->decimal('subtotal', 15, 2)->default(0.00);
            $table->decimal('tax', 15, 2)->default(0.00);
            $table->decimal('total', 15, 2)->default(0.00);

            $table->index('workorder_id');
        });

        Schema::create('workorder_items', function (Blueprint $table)
        {
            $table->increments('id');
            $table->timestamps();
            $table->integer('workorder_id');
            $table->integer('tax_rate_id');
            $table->integer('tax_rate_2_id')->default(0);
            $table->string('resource_table',45)->nullable();
            $table->integer('resource_id')->nullable();
            $table->string('name');
            $table->text('description');
            $table->decimal('quantity', 10, 2)->default(0.00);
            $table->integer('display_order');
            $table->decimal('price', 15, 2)->default(0.00);
            $table->index('workorder_id');
            $table->index('display_order');
            $table->index('tax_rate_id');
            $table->index('tax_rate_2_id');
        });

        Schema::create('workorder_item_amounts', function (Blueprint $table)
        {
            $table->increments('id');
            $table->timestamps();
            $table->integer('item_id');
            $table->decimal('subtotal', 15, 2)->default(0.00);
            $table->decimal('tax_1', 15, 2)->default(0.00);
            $table->decimal('tax_2', 15, 2)->default(0.00);
            $table->decimal('tax', 15, 2)->default(0.00);
            $table->decimal('total', 15, 2)->default(0.00);

            $table->index('item_id');
        });

        Schema::create('workorder_tax_rates', function (Blueprint $table)
        {
            $table->increments('id');
            $table->timestamps();
            $table->integer('workorder_id');
            $table->integer('tax_rate_id');
            $table->boolean('include_item_tax')->default(0);
            $table->decimal('tax_total', 15, 2)->default(0.00);

            $table->index('workorder_id');
            $table->index('tax_rate_id');
        });

        Schema::create('employees', function (Blueprint $table)
        {
            $table->increments('id');
            $table->timestamps();
            $table->integer('number');
            $table->text('first_name');
            $table->text('last_name');
            $table->text('full_name');
            $table->text('short_name');
            $table->text('title');
            $table->decimal('billing_rate',15,2)->default(0.00);
            $table->boolean('schedule')->default(0);
            $table->boolean('active')->default(0);
            $table->boolean('driver')->default(0);
        });

        //create resources table
        Schema::create('resources', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('name',85);
            $table->text('description')->nullable();
            $table->string('serialnum',85)->nullable();
            $table->boolean('active')->default(1);
            $table->decimal('cost',7,2)->nullable();
            $table->string('category',20)->nullable();
            $table->string('type',20)->nullable();
            $table->tinyInteger('numstock')->unsigned()->nullable();
        });
        //insert workorder group
        DB::table('groups')->insert(array('name' => 'Workorder Default','format' => '{NUMBER}','next_id' => '10000','left_pad' => '0'));

        //insert workorder settings
        DB::table('settings')->insert(array('setting_key' => 'addonWorkorderScheduler','setting_value' => '0'));
        DB::table('settings')->insert(array('setting_key' => 'addonWorkorderRestolup','setting_value' => '1'));
        DB::table('settings')->insert(array('setting_key' => 'addonWorkorderEmptolup','setting_value' => '1'));
        DB::table('settings')->insert(array('setting_key' => 'addonWorkorderworkorderTemplate','setting_value' => 'Workordercustom.blade.php'));
        DB::table('settings')->insert(array('setting_key' => 'addonWorkorderworkorderGroup','setting_value' => '3'));
        DB::table('settings')->insert(array('setting_key' => 'addonWorkorderworkorderExpires','setting_value' => '15'));
        DB::table('settings')->insert(array('setting_key' => 'addonWorkorderworkorderTerms','setting_value' => ''));
        DB::table('settings')->insert(array('setting_key' => 'addonWorkorderworkorderFooter','setting_value' => ''));
        DB::table('settings')->insert(array('setting_key' => 'addonWorkorderconvertWorkorderTerms','setting_value' => 'workorder'));
        DB::table('settings')->insert(array('setting_key' => 'addonWorkorderEnableLegacyCalendar','setting_value' => '0'));
        DB::table('settings')->insert(array('setting_key' => 'addonWorkorderLegacyCalendarScript','setting_value' => 'update_calendar.sql'));
        DB::table('settings')->insert(array('setting_key' => 'addonWorkorderVersion','setting_value' => '1.0.2'));

         //add category column to item_lookups
        Schema::table('item_lookups', function (Blueprint $table) {
            $table->text('category')->after('price')->nullable();
            $table->text('resource_table')->after('category')->nullable();
            $table->text('resource_id')->after('resource_table')->nullable();
        });
        //add resource info to invoice_items
        Schema::table('invoice_items', function (Blueprint $table) {
            $table->string('resource_table', 45)->nullable()->after('tax_rate_2_id');
            $table->integer('resource_id')->nullable()->after('resource_table');
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // for laravel 5.2+  Schema::disableForeignKeyConstraints();
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        Schema::drop('workorders');
        Schema::drop('workorders_custom');
        Schema::drop('workorder_amounts');
        Schema::drop('workorder_items');
        Schema::drop('workorder_item_amounts');
        Schema::drop('workorder_tax_rates');
        Schema::drop('employees');
        Schema::drop('resources');

        Schema::table('item_lookups', function (Blueprint $table) {
            $table->dropColumn('category');
            $table->dropColumn('resource_table');
            $table->dropColumn('resource_id');
        });

        Schema::table('invoice_items', function (Blueprint $table) {
            $table->dropColumn('resource_table');
            $table->dropColumn('resource_id');
        });

        //delete workorder group
        DB::table('groups')->where('name', '=' ,'Workorder Default')->delete();

        //delete workorder settings
        DB::table('settings')->where('setting_key', '=', 'addonWorkorderScheduler')->delete();
        DB::table('settings')->where('setting_key', '=', 'addonWorkorderRestolup')->delete();
        DB::table('settings')->where('setting_key', '=', 'addonWorkorderEmptolup')->delete();
        DB::table('settings')->where('setting_key', '=', 'addonWorkorderworkorderTemplate')->delete();
        DB::table('settings')->where('setting_key', '=', 'addonWorkorderworkorderGroup')->delete();
        DB::table('settings')->where('setting_key', '=', 'addonWorkorderworkorderExpires')->delete();
        DB::table('settings')->where('setting_key', '=', 'addonWorkorderworkorderTerms')->delete();
        DB::table('settings')->where('setting_key', '=', 'addonWorkorderworkorderFooter')->delete();
        DB::table('settings')->where('setting_key', '=', 'addonWorkorderconvertWorkorderTerms')->delete();
        DB::table('settings')->where('setting_key', '=', 'addonWorkorderEnableLegacyCalendar')->delete();
        DB::table('settings')->where('setting_key', '=', 'addonWorkorderLegacyCalendarScript')->delete();
        DB::table('settings')->where('setting_key', '=', 'addonWorkorderVersion')->delete();
        DB::table('settings')->where('setting_key', '=', 'widgetEnabledWorkorderSummary')->update(['setting_value' => '0']);

        // for laravel 5.2+  Schema::enableForeignKeyConstraints();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

    }
}
