<?php

/**
 * This file is part of Workorders Addon for FusionInvoice.
 * (c) Cytech <cytech@cytech-eng.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Addons\Workorders\Support;

use FI\Events\InvoiceModified;
use FI\Modules\CustomFields\Models\CustomField;
use FI\Modules\Groups\Models\Group;
use FI\Modules\Invoices\Models\Invoice;
use FI\Modules\Invoices\Models\InvoiceItem;
use FI\Support\Statuses\InvoiceStatuses;
use FI\Support\Statuses\QuoteStatuses;

class WorkorderToInvoice
{
    public function convert($workorder, $invoiceDate, $dueAt, $groupId)
    {
        $record = [
            'client_id'         => $workorder->client_id,
            'invoice_date'        => $invoiceDate,
            'due_at'            => $dueAt,
            'group_id'          => $groupId,
            'number'             => Group::generateNumber($groupId),
            'user_id'           => $workorder->user_id,
            'invoice_status_id' => InvoiceStatuses::getStatusId('draft'),
            'terms'             => ((config('workorder_settings.convertWorkorderTerms') == 'workorder') ? $workorder->terms : config('fi.invoiceTerms')),
            'footer'            => $workorder->footer,
            'currency_code'     => $workorder->currency_code,
            'exchange_rate'     => $workorder->exchange_rate,
            'summary'           => $workorder->summary,
            'discount'          => $workorder->discount,
            'company_profile_id' => $workorder->company_profile_id,
        ];

        $toInvoice = Invoice::create($record);

        CustomField::copyCustomFieldValues($workorder, $toInvoice);

        $workorder->invoice_id = $toInvoice->id;
	    $workorder->workorder_status_id = QuoteStatuses::getStatusId('approved');
        $workorder->save();

        foreach ($workorder->workorderItems as $item)
        {
            $itemRecord = [
                'invoice_id'    => $toInvoice->id,
                'name'          => $item->name,
                'description'   => $item->description,
                'quantity'      => $item->quantity,
                'price'         => $item->price,
                'tax_rate_id'   => $item->tax_rate_id,
                'tax_rate_2_id' => $item->tax_rate_2_id,
                'resource_table' => $item->resource_table,
                'resource_id'    => $item->resource_id,
                'display_order' => $item->display_order
            ];

            InvoiceItem::create($itemRecord);
        }

        event(new InvoiceModified($toInvoice));

        return $toInvoice;
    }
}