<?php

/**
 * This file is part of Workorders Addon for FusionInvoice.
 * (c) Cytech <cytech@cytech-eng.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Addons\Workorders\Support;

use DateTime;
use FI\Support\DateFormatter as FIDateFormatter;

class DateFormatter extends FIDateFormatter
{
    /**
     * Converts a stored time to the user formatted date.
     *
     * @param time $time The H:i:s standardized time
     * @return time             The user formatted time
     */
    public static function formattime($time = null)
    {
        $time = new DateTime($time);

        return $time->format('H:i');
    }

    /**
     * Converts a user submitted time back to standard H:i:s format.
     *
     * @param  time $userTime The user submitted time
     * @return time             The H:i:s standardized time
     */
    public static function unformattime($userTime = null)
    {
        if ($userTime)
        {
            $time = DateTime::createFromFormat('H:i', $userTime);

            return $time->format('Y-m-d H:i:s');
        }

        return null;
    }


}