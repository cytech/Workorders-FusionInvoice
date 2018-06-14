<?php

/**
 * This file is part of Workorders Addon for FusionInvoice.
 * (c) Cytech <cytech@cytech-eng.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace Addons\Workorders\Support;

use FI\Support\FileNames as FIFileNames;

class FileNames extends FIFileNames
{

    public static function workorder($workorder)
    {
        return trans('Workorders::texts.workorder') . '_' . str_replace('/', '-', $workorder->number) . '.pdf';
    }

    public static function batchprint()
    {
        return trans('Workorders::texts.batchprint') . '_' . 'batchprint' . '.pdf';
    }
}