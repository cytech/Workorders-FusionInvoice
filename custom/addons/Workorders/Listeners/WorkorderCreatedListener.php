<?php

namespace Addons\Workorders\Listeners;

use Addons\Workorders\Events\WorkorderCreated;
use Addons\Workorders\Models\WorkorderCustom;
use FI\Modules\Groups\Models\Group;
use Addons\Workorders\Support\WorkorderCalculate;

class WorkorderCreatedListener
{
    public function __construct(WorkorderCalculate $workorderCalculate)
    {
        $this->workorderCalculate = $workorderCalculate;
    }

    public function handle(WorkorderCreated $event)
    {
        // Create the empty workorder amount record
        $this->workorderCalculate->calculate($event->workorder);

        // Increment the next id
        Group::incrementNextId($event->workorder);

        // Create the custom quote record.
        $event->workorder->custom()->save(new WorkorderCustom());
    }
}
