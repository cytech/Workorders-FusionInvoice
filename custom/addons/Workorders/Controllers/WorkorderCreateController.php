<?php

/**
 * This file is part of Workorders Addon for FusionInvoice.
 * (c) Cytech <cytech@cytech-eng.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
 
namespace Addons\Workorders\Controllers;

use FI\Http\Controllers\Controller;
use FI\Modules\Clients\Models\Client;
use FI\Modules\CompanyProfiles\Models\CompanyProfile;
use FI\Modules\Groups\Models\Group;
use Addons\Workorders\Models\Workorder;
use Addons\Workorders\Requests\WorkorderStoreRequest;
use Addons\Workorders\Support\DateFormatter;

class WorkorderCreateController extends Controller
{
    public function create()
    {
        return view('Workorders::workorders.partials._modal_create')
            ->with('companyProfiles', CompanyProfile::getList())
            ->with('groups', Group::getList());
    }

    public function store(WorkorderStoreRequest $request)
    {
        $input = request()->except('client_name');

        $input['client_id']  = Client::firstOrCreateByUniqueName($request->input('client_name'))->id;
        $input['workorder_date'] = DateFormatter::unformat($input['workorder_date']);

        $workorder = Workorder::create($input);
        return response()->json(['success' => true, 'id' => $workorder->id], 200);
    }
}