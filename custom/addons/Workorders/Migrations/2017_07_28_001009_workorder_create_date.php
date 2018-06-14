<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class WorkorderCreateDate extends Migration
{
    public function up()
    {
        Schema::table('workorders', function (Blueprint $table)
        {
            $table->date('workorder_date')->after('updated_at');
        });

        DB::table('workorders')->update(['workorder_date' => DB::raw('created_at')]);
    }

    public function down()
    {
        //
    }
}
