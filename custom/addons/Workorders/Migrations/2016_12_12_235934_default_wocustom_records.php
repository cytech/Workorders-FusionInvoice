<?php

use Addons\Workorders\Models\Workorder;
use Addons\Workorders\Models\WorkorderCustom;
use Illuminate\Database\Migrations\Migration;

class DefaultWOcustomRecords extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        // Insert missing workorder custom records.
        /*$workorders = Workorder::whereNotIn('id', function ($query)
        {
            $query->select('workorder_id')->from('workorders_custom');
        })->get();*/
		//2018-02-16 had to replace above due to fail when Workorder Model was changed
        $workorders = DB::raw("select * from `workorders` where  `id` not in (select `workorder_id` from `workorders_custom`)");

        foreach ($workorders as $workorder)
        {
            $workorder->custom()->save(new WorkorderCustom());
        }

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
