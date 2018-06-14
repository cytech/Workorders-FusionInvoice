<?php

/**
 * *
 *  * This file is part of Workorder Addon for FusionInvoice.
 *  * (c) Cytech <cytech@cytech-eng.com>
 *  *
 *  * For the full copyright and license information, please view the LICENSE
 *  * file that was distributed with this source code.
 *
 *
 */

namespace Addons\Workorders\Requests;

use FI\Support\NumberFormatter;
use Illuminate\Foundation\Http\FormRequest;

class APIWorkorderItemRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function attributes()
    {
        return [
            'name'     => trans('fi.name'),
            'quantity' => trans('fi.quantity'),
            'price'    => trans('fi.price'),
        ];
    }

    public function prepareForValidation()
    {
        $request = $this->all();

        $request['quantity'] = NumberFormatter::unformat($request['quantity']);
        $request['price']    = NumberFormatter::unformat($request['price']);

        $this->replace($request);
    }

    public function rules()
    {
        return [
            'workorder_id' => 'required',
            'name'     => 'required_with:price,quantity',
            'quantity' => 'required_with:price,name|numeric',
            'price'    => 'required_with:name,quantity|numeric',
        ];
    }
}