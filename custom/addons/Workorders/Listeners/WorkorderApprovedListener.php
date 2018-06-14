<?php

namespace Addons\Workorders\Listeners;

use Addons\Workorders\Events\WorkorderApproved;
use FI\Modules\MailQueue\Support\MailQueue;
use Addons\Workorders\Support\WorkorderToInvoice;
use Addons\Workorders\Support\DateFormatter;
use FI\Support\Parser;

class WorkorderApprovedListener
{
     public function __construct(MailQueue $mailQueue, WorkorderToInvoice $workorderToInvoice)
    {
        $this->mailQueue              = $mailQueue;
        $this->workorderToInvoice = $workorderToInvoice;
    }

    public function handle(WorkorderApproved $event)
    {
        // Create the activity record
        $event->workorder->activities()->create(['activity' => 'public.approved']);

        // If applicable, convert the workorder to an invoice when workorder is approved
        if (config('fi.convertWorkorderWhenApproved'))
        {
            $this->workorderToInvoice->convert(
                $event->workorder,
                date('Y-m-d'),
                DateFormatter::incrementDateByDays(date('Y-m-d'), config('fi.invoicesDueAfter')),
                config('fi.invoiceGroup')
            );
        }
        
        $parser = new Parser($event->workorder);

        $mail = $this->mailQueue->create($event->workorder, [
            'to'         => [$event->workorder->user->email],
            'cc'         => [config('fi.mailDefaultCc')],
            'bcc'        => [config('fi.mailDefaultBcc')],
            'subject'    => trans('fi.workorder_status_change_notification'),
            'body'       => $parser->parse('workorderApprovedEmailBody'),
            'attach_pdf' => config('fi.attachPdf')
        ]);

        $this->mailQueue->send($mail->id);
    }
}
