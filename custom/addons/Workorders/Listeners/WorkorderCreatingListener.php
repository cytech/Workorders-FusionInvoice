<?php

namespace Addons\Workorders\Listeners;

use Addons\Workorders\Events\WorkorderCreating;
use FI\Modules\Currencies\Support\CurrencyConverterFactory;
use FI\Modules\Groups\Models\Group;
//use FI\Support\DateFormatter;
use FI\Support\Statuses\QuoteStatuses;
use Addons\Workorders\Support\DateFormatter;

class WorkorderCreatingListener
{
    public function handle(WorkorderCreating $event)
    {
        $workorder = $event->workorder;

        if (!$workorder->client_id)
        {
            // This needs to throw an exception since this is required.
        }

        if (!$workorder->user_id)
        {
            $workorder->user_id = auth()->user()->id;
        }

        if (!$workorder->workorder_date)
        {
            $workorder->workorder_date = date('Y-m-d');
        }

        if (!$workorder->job_date)
        {
            $workorder->job_date = date('Y-m-d');
        }

        if (!$workorder->start_time)
        {
            $workorder->start_time = '08:00';
        }

        if (!$workorder->end_time)
        {
            $workorder->end_time = '09:00';
        }

        if (!$workorder->expires_at)
        {
            $workorder->expires_at = DateFormatter::incrementDateByDays($workorder->workorder_date->format('Y-m-d'), config('workorder_settings.workorderExpires'));
        }

        if (!$workorder->company_profile_id)
        {
            $workorder->company_profile_id = config('fi.defaultCompanyProfile');
        }

        if (!$workorder->group_id)
        {
            $workorder->group_id = config('workorder_settings.workorderGroup');
        }

        if (!$workorder->number)
        {
            $workorder->number = Group::generateNumber($workorder->group_id);
        }

        if (!isset($workorder->terms))
        {
            $workorder->terms = config('workorder_settings.workorderTerms');
        }

        if (!isset($workorder->footer))
        {
            $workorder->footer = config('workorder_settings.workorderFooter');
        }

        if (!$workorder->workorder_status_id)
        {
            $workorder->workorder_status_id = QuoteStatuses::getStatusId('draft');
        }

        if (!$workorder->currency_code)
        {
            $workorder->currency_code = $workorder->client->currency_code;
        }

        if (!$workorder->template)
        {
            $workorder->template = config('workorder_settings.workorderTemplate');
        }

        if ($workorder->currency_code == config('fi.baseCurrency'))
        {
            $workorder->exchange_rate = 1;
        }
        elseif (!$workorder->exchange_rate)
        {
            $currencyConverter    = CurrencyConverterFactory::create();
            $workorder->exchange_rate = $currencyConverter->convert(config('fi.baseCurrency'), $workorder->currency_code);
        }

        $workorder->url_key = str_random(32);
    }
}
