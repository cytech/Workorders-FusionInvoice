<?php

namespace Addons\Workorders\Listeners;

use Addons\Workorders\Events\WorkorderModified;
use Addons\Workorders\Support\WorkorderCalculate;
use Addons\Workorders\Repositories\WorkorderToSchedulerRepository;

class WorkorderModifiedListener
{
    public function __construct(WorkorderCalculate $workorderCalculate,
                                WorkorderToSchedulerRepository $workorderToSchedulerRepository)
    {
        $this->workorderCalculate = $workorderCalculate;
        $this->workorderToSchedulerRepository = $workorderToSchedulerRepository;
    }

    public function handle(WorkorderModified $event)
    {
        // Calculate the workorder and item amounts
        $this->workorderCalculate->calculate($event->workorder);

        // Update the event in Scheduler
        if (config('workorder_settings.scheduler')) {
            $this->workorderToSchedulerRepository->update($event->workorder->id);
        }


    }
}
