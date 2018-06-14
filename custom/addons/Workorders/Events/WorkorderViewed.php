<?php

namespace Addons\Workorders\Events;

use Addons\Workorders\Models\Workorder;
use FI\Events\Event;
use Illuminate\Queue\SerializesModels;

class WorkorderViewed extends Event
{
    use SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Workorder $workorder)
    {
        $this->workorder = $workorder;
    }
}
