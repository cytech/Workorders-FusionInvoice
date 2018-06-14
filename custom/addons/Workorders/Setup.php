<?php

/**
 * This file is part of Workorders Addon for FusionInvoice.
 * (c) Cytech <cytech@cytech-eng.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Addons\Workorders;

use Illuminate\Support\Facades\Schema;

class Setup
{
    public $properties = [
        // This is the name of the module.
        'name'            => 'Workorders',

        // The name of the author.
        'author_name'     => 'Dave Albright',

        // The URL to the author.
        'author_url'      => 'https://www.cytech-eng.com',

        // The viewfolder.viewname to the navigation menu file, if exists.
        // This file must have a .blade.php extension.
        'navigation_menu' => 'workorders._navigation',

        // The viewfolder.viewname to the navigation report file, if exists.
        // This file must have a .blade.php extension.
        'navigation_reports' => 'workorders._reports',

        // The viewfolder.viewname to the system menu view file, if exists.
        // This file must have a .blade.php extension.
        'system_menu'        => 'workorders._system'
    ];

    public function install()
    {

    }

    public function uninstall()
    {
        /*Schema::drop('workorders');
        Schema::drop('workorders_custom');
        Schema::drop('workorder_amounts');
        Schema::drop('workorder_items');
        Schema::drop('workorder_item_amounts');
        Schema::drop('workorder_tax_rates');
        Schema::drop('employees');

        Schema::table('item_lookups', function (Blueprint $table) {
            $table->dropColumn('category');
        });
        */

    }

}