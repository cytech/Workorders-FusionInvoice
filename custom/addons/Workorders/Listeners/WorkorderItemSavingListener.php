<?php

namespace Addons\Workorders\Listeners;

use Addons\Workorders\Events\WorkorderItemSaving;
use Addons\Workorders\Models\WorkorderItem;

class WorkorderItemSavingListener
{
    public function handle(WorkorderItemSaving $event)
    {
        $item = $event->workorderItem;

        $applyExchangeRate = $item->apply_exchange_rate;
        unset($item->apply_exchange_rate);

        if ($applyExchangeRate == true)
        {
            $item->price = $item->price * $item->quote->exchange_rate;
        }

        if (!$item->display_order)
        {
            $displayOrder = WorkorderItem::where('workorder_id', $item->workorder_id)->max('display_order');

            $displayOrder++;

            $item->display_order = $displayOrder;
        }
    }
}
