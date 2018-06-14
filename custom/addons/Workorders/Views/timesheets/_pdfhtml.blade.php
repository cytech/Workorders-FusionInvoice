@extends('reports.layouts.master')

@section('content')

    <table>
        <tr>
            <td style="width: 50%;" valign="top">
                <span style="font-weight: bold">{{ $results['total_records'] }} {{ trans('Workorders::texts.records_found_criteria') }}</span><br>
            </td>
            <td style="width: 50%; text-align: right;" valign="top">
                {{--{!! $logo !!}<br>--}}
                <span style="font-weight: bold">{{ $results['companyProfile_company'] }}</span><br>

            </td>
        </tr>
    </table>
<h2 style="margin-bottom: 0;">{{ trans('Workorders::texts.timesheet') }}</h2>
<h3 style="margin-top: 0;">{{ $results['from_date'] }} - {{ $results['to_date'] }}</h3>
<br>
<table class="alternate">
    <thead>
    <tr>
        <th>{{ trans('Workorders::texts.invoicenumber') }}</th>
        <th>{{ trans('Workorders::texts.customername') }}</th>
        <th>{{ trans('Workorders::texts.datefinished') }}</th>
        <th>{{ trans('Workorders::texts.itemname') }}</th>
        <th>{{ trans('Workorders::texts.itemqty') }}</th>
        <th>{{ trans('Workorders::texts.fullname') }}</th>
        <th>{{ trans('Workorders::texts.empnumber') }}</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($results['records'] as $result)
    <tr>
        <td>{{ $result['number'] }}</td>
        <td>{{ $result['client_name'] }}</td>
        <td>{{ $result['formatted_invoice_date'] }}</td>
        <td>{{ $result['item_name'] }}</td>
        <td>{{ $result['item_qty'] }}</td>
        <td>{{ $result['full_name'] }}</td>
        <td>{{ $result['employee_number'] }}</td>
    </tr>
    @endforeach
    <tr>
        <td colspan="3"></td>
        <td style="font-weight: bold;">{{ trans('Workorders::texts.totalhours') }}</td>
        <td style="font-weight: bold;">{{ $results['total_hours'] }}</td>
    </tr>
    </tbody>
</table>

@stop