@include('layouts._datepicker')

@include('Workorders::workorders.partials._js_workorder_to_invoice')

<div class="modal fade" id="modal-workorder-to-invoice">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">{{ trans('Workorders::texts.workorder_to_invoice') }}</h4>
            </div>
            <div class="modal-body">

                <div id="modal-status-placeholder"></div>

                <form class="form-horizontal">

                    <div class="form-group">
                        <label class="col-sm-3 control-label">{{ trans('fi.date') }}</label>

                        <div class="col-sm-9">
                            {{--{!! Form::text('created_at', $created_at, ['id' => 'to_invoice_created_at', 'class' => 'form-control']) !!}--}}
                            {!! Form::text('workorder_date', $workorder_date, ['id' => 'to_invoice_workorder_date', 'class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">{{ trans('fi.group') }}</label>

                        <div class="col-sm-9">
                            {!! Form::select('group_id', $groups, config('fi.invoiceGroup'), ['id' => 'to_invoice_group_id', 'class' => 'form-control']) !!}
                        </div>
                    </div>

                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('fi.cancel') }}</button>
                <button type="button" id="btn-workorder-to-invoice-submit"
                        class="btn btn-primary">{{ trans('fi.submit') }}</button>
            </div>
        </div>
    </div>
</div>