<?php

namespace Addons\Workorders\Events;

use Addons\Workorders\Models\WorkorderItem;
use FI\Events\Event;
use Illuminate\Queue\SerializesModels;

class WorkorderItemSaving extends Event
{
    use SerializesModels;

    public function __construct(WorkorderItem $workorderItem)
    {
        $this->workorderItem = $workorderItem;
    }
}
