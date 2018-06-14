<?php

/**
 * This file is part of Workorders Addon for FusionInvoice.
 * (c) Cytech <cytech@cytech-eng.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Addons\Workorders;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Addons\Workorders\Models\Workorder;
use Addons\Workorders\Models\Setting;
use Config;
use Schema;
use Form;

class AddonServiceProvider extends ServiceProvider
{


    public function boot()
    {
	    if (Schema::hasTable('workorder_settings')) {
		    foreach (Setting::all() as $setting) {
			    Config::set('workorder_settings.'.$setting->setting_key, $setting->setting_value);
		    }
	    }

	    Form::macro('wobreadcrumbs', function ($status = false) {
		    $str = '<ol class="breadcrumb">';

		    // Get the breadcrumbs by exploding the current path.
		    $basePath = substr($_SERVER['SCRIPT_NAME'], 0, strrpos($_SERVER['SCRIPT_NAME'], '/') + 1);
		    $parts = explode('?', isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '');
		    $path = $parts[0];

		    if ($basePath != '/') {
			    $path = str_replace($basePath, '', $path);
		    }
		    $crumbs = explode('/', $path);

		    foreach ($crumbs as $key => $val) {
			    if (is_numeric($val)) {
				    unset($crumbs[$key]);
			    }
		    }

		    $crumbs = array_values($crumbs);
		    $modcrumb = null;
		    for ($i = 0; $i < count($crumbs); $i++) {
			    $crumb = trim($crumbs[$i]);
			    if (! $crumb) {
				    continue;
			    }
			    if ($crumb == 'company') {
				    return '';
			    }

			    if (!$modcrumb) {
				    $modcrumb = $crumb;
				    $name     = trans( 'Workorders::texts.'.$crumb );
			    } elseif ($modcrumb){
				    $name     = trans( 'Workorders::texts.'.$crumb );
			    } else {
				    $name = trans("Workorders::texts.$crumb");
			    }

			    if ($i == count($crumbs) - 1) {
				    $str .= "<li class='active'>$name</li>";
			    } elseif ($i <= count($crumbs) - 2 && $i >= 2) {
				    $str .= '<li>'.link_to($modcrumb.'/'.$crumb, $name).'</li>';
			    }else {
				    $str .= '<li>'.link_to($crumb, $name).'</li>';
			    }
		    }

		    if ($status) {
			    $str .= $status;
		    }

		    return $str . '</ol>';
	    });

        Event::listen('FI\Events\InvoiceDeleted', function ($event)
        {
            Workorder::where('invoice_id', $event->invoice->id)->update(['invoice_id' => 0]);
        });

        Event::listen('Addons\Workorders\Events\WorkorderApproved','Addons\Workorders\Listeners\WorkorderApprovedListener');
        Event::listen('Addons\Workorders\Events\WorkorderCreated','Addons\Workorders\Listeners\WorkorderCreatedListener');
        Event::listen('Addons\Workorders\Events\WorkorderCreating','Addons\Workorders\Listeners\WorkorderCreatingListener');
        Event::listen('Addons\Workorders\Events\WorkorderDeleted','Addons\Workorders\Listeners\WorkorderDeletedListener');
        Event::listen('Addons\Workorders\Events\WorkorderEmailed','Addons\Workorders\Listeners\WorkorderEmailedListener');
        Event::listen('Addons\Workorders\Events\WorkorderItemSaving','Addons\Workorders\Listeners\WorkorderItemSavingListener');
        Event::listen('Addons\Workorders\Events\WorkorderModified','Addons\Workorders\Listeners\WorkorderModifiedListener');
        Event::listen('Addons\Workorders\Events\WorkorderRejected','Addons\Workorders\Listeners\WorkorderRejectedListener');
        Event::listen('Addons\Workorders\Events\WorkorderViewed','Addons\Workorders\Listeners\WorkorderViewedListener');

		//set view namespace - fi uses addLocation and there are conflicts with
	    // identical view names between addons
	    $this->app->view->addNamespace('Workorders',base_path('custom/addons') . '/Workorders/Views');


    }

    public function register()
    {
	    //
    }
}
