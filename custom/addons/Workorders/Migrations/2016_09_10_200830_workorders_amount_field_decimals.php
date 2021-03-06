<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class WorkordersAmountFieldDecimals extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('workorder_amounts', function (Blueprint $table)
        {
            $table->decimal('subtotal', 20, 4)->change();
            $table->decimal('discount', 20, 4)->change();
            $table->decimal('tax', 20, 4)->change();
            $table->decimal('total', 20, 4)->change();
        });

        Schema::table('workorder_items', function (Blueprint $table)
        {
            $table->decimal('quantity', 20, 4)->change();
            $table->decimal('price', 20, 4)->change();
        });

        Schema::table('workorder_item_amounts', function (Blueprint $table)
        {
            $table->decimal('subtotal', 20, 4)->change();
            $table->decimal('tax_1', 20, 4)->change();
            $table->decimal('tax_2', 20, 4)->change();
            $table->decimal('tax', 20, 4)->change();
            $table->decimal('total', 20, 4)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('workorder_amounts', function (Blueprint $table)
        {
            $table->decimal('subtotal', 15, 2)->change();
            $table->decimal('discount', 15, 2)->change();
            $table->decimal('tax', 15, 2)->change();
            $table->decimal('total', 15, 2)->change();
        });

        Schema::table('workorder_items', function (Blueprint $table)
        {
            $table->decimal('quantity', 15, 2)->change();
            $table->decimal('price', 15, 2)->change();
        });

        Schema::table('workorder_item_amounts', function (Blueprint $table)
        {
            $table->decimal('subtotal', 15, 2)->change();
            $table->decimal('tax_1', 15, 2)->change();
            $table->decimal('tax_2', 15, 2)->change();
            $table->decimal('tax', 15, 2)->change();
            $table->decimal('total', 15, 2)->change();
        });
    }
}
