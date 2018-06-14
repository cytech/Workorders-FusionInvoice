<?php

namespace Addons\Workorders\Events;

use Addons\Workorders\Models\Workorder;
use FI\Events\Event;
use Illuminate\Queue\SerializesModels;

class WorkorderEmailed extends Event
{
    use SerializesModels;

    public function __construct(Workorder $workorder)
    {
        $this->workorder = $workorder;
    }
}