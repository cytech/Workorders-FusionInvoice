<?php

namespace Addons\Workorders\Listeners;

use Addons\Workorders\Events\WorkorderEmailing;
use FI\Support\DateFormatter;

class WorkorderEmailingListener
{
    public function handle(WorkorderEmailing $event)
    {
        if (config('fi.resetQuoteDateEmailDraft') and $event->workorder->status_text == 'draft')
        {
            $event->workorder->workorder_date = date('Y-m-d');
            $event->workorder->expires_at = DateFormatter::incrementDateByDays(date('Y-m-d'), config('workorder_settings.workorderExpires'));
            $event->workorder->save();
        }
    }
}
