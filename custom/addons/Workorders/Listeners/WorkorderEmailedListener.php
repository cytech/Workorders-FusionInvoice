<?php

namespace Addons\Workorders\Listeners;

use Addons\Workorders\Events\WorkorderEmailed;
use FI\Support\Statuses\QuoteStatuses;

class WorkorderEmailedListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  WorkorderEmailed $event
     * @return void
     */
    public function handle(WorkorderEmailed $event)
    {
        // Change the status to sent if the status is currently draft
        if ($event->workorder->workorder_status_id == QuoteStatuses::getStatusId('draft'))
        {
            $event->workorder->workorder_status_id = QuoteStatuses::getStatusId('sent');
            $event->workorder->save();
        }
    }
}
