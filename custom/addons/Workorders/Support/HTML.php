<?php

/**
 * This file is part of Workorders Addon for FusionInvoice.
 * (c) Cytech <cytech@cytech-eng.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
 
namespace Addons\Workorders\Support;

use Addons\Workorders\Events\WorkorderHTMLCreating;
use FI\Support\HTML as FIHTML;

class HTML extends FIHTML
{

    public static function workorder($workorder)
    {
        app()->setLocale($workorder->client->language);

        config(['fi.baseCurrency' => $workorder->currency_code]);

        event(new WorkorderHTMLCreating($workorder));

        $template = str_replace('.blade.php', '', $workorder->template);

        if (view()->exists('workorder_templates.' . $template))
        {
            $template = 'workorder_templates.' . $template;
        }
        else //default fi templates
        {
            $template = 'templates.workorders.default';
        }

        return view($template)
            ->with('workorder', $workorder)
            ->with('logo', $workorder->companyProfile->logo())->render();
    }
}