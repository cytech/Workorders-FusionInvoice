@include('layouts._datepicker')

<div id="workorder-dashboard-totals-widget">
    <script type="text/javascript">
        $(function () {

            $('.create-workorder').click(function () {
                clientName = $(this).data('unique-name');
                $('#modal-placeholder').load('{{ route('workorders.create') }}');
            });

            $('.workorder-dashboard-total-change-option').click(function () {
                var option = $(this).data('id');

                $.post("{{ route('widgets.dashboard.workorderSummary.renderPartial') }}", {
                    widgetWorkorderSummaryDashboardTotals: option,
                    widgetWorkorderSummaryDashboardTotalsFromDate: $('#workorder-dashboard-total-setting-from-date').val(),
                    widgetWorkorderSummaryDashboardTotalsToDate: $('#workorder-dashboard-total-setting-to-date').val()
                }, function (data) {
                    $('#workorder-dashboard-totals-widget').html(data);
                });

            });

            $('#workorder-dashboard-total-setting-from-date').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true
            });
            $('#workorder-dashboard-total-setting-to-date').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true
            });
        });
    </script>

    <section class="content">

        <div class="box box-solid">
            <div class="box-header">
                <h3 class="box-title">{{ trans('Workorders::texts.workorder_summary') }}</h3>
                <div class="box-tools pull-right">
                    <div class="btn-group">
                        <button type="button" class="btn btn-box-tool dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-calendar"></i> {{ $workorderDashboardTotalOptions[config('fi.widgetWorkorderSummaryDashboardTotals')] }}
                        </button>
                        <ul class="dropdown-menu" role="menu">
                            @foreach ($workorderDashboardTotalOptions as $key => $option)
                                <li>
                                    @if ($key != 'custom_date_range')
                                        <a href="#" onclick="return false;" class="workorder-dashboard-total-change-option" data-id="{{ $key }}">{{ $option }}</a>
                                    @else
                                        <a href="#" onclick="return false;" data-toggle="modal" data-target="#workorder-summary-widget-modal">{{ $option }}</a>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <button class="btn btn-box-tool create-workorder"><i class="fa fa-plus"></i> {{ trans('Workorders::texts.create_workorder') }}</button>
                </div>
            </div>
            <div class="box-body">

                <div class="row">
                    <div class="col-lg-6 col-md-12">
                        <div class="small-box bg-purple">
                            <div class="inner">
                                <h3>{{ $workordersTotalDraft }}</h3>

                                <p>{{ trans('Workorders::texts.draft_workorders') }}</p>
                            </div>
                            <div class="icon"><i class="ion ion-edit"></i></div>
                            <a class="small-box-footer" href="{{ route('workorders.index') }}?status=draft">
                                {{ trans('Workorders::texts.view_draft_workorders') }} <i class="fa fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <div class="small-box bg-olive">
                            <div class="inner">
                                <h3>{{ $workordersTotalSent }}</h3>

                                <p>{{ trans('Workorders::texts.sent_workorders') }}</p>
                            </div>
                            <div class="icon"><i class="ion ion-share"></i></div>
                            <a class="small-box-footer" href="{{ route('workorders.index') }}?status=sent">
                                {{ trans('Workorders::texts.view_sent_workorders') }} <i class="fa fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-12">
                        <div class="small-box bg-orange">
                            <div class="inner">
                                <h3>{{ $workordersTotalRejected }}</h3>

                                <p>{{ trans('Workorders::texts.rejected_workorders') }}</p>
                            </div>
                            <div class="icon"><i class="ion ion-thumbsdown"></i></div>
                            <a class="small-box-footer" href="{{ route('workorders.index') }}?status=rejected">
                                {{ trans('Workorders::texts.view_rejected_workorders') }} <i class="fa fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <div class="small-box bg-blue">
                            <div class="inner">
                                <h3>{{ $workordersTotalApproved }}</h3>

                                <p>{{ trans('Workorders::texts.approved_workorders') }}</p>
                            </div>
                            <div class="icon"><i class="ion ion-thumbsup"></i></div>
                            <a class="small-box-footer" href="{{ route('workorders.index') }}?status=approved">
                                {{ trans('Workorders::texts.view_approved_workorders') }} <i class="fa fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>

    <div class="modal fade" id="workorder-summary-widget-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel">{{ trans('fi.custom_date_range') }}</h4>
                </div>
                <div class="modal-body">

                    <div class="form-group">
                        <label>{{ trans('fi.from_date') }} (yyyy-mm-dd):</label>
                        {!! Form::text('setting_widgetWorkorderSummaryDashboardTotalsFromDate', config('fi.widgetWorkorderSummaryDashboardTotalsFromDate'), ['class' => 'form-control', 'id' => 'workorder-dashboard-total-setting-from-date']) !!}
                    </div>

                    <div class="form-group">
                        <label>{{ trans('fi.to_date') }} (yyyy-mm-dd):</label>
                        {!! Form::text('setting_widgetWorkorderSummaryDashboardTotalsToDate', config('fi.widgetWorkorderSummaryDashboardTotalsToDate'), ['class' => 'form-control', 'id' => 'workorder-dashboard-total-setting-to-date']) !!}
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('fi.cancel') }}</button>
                    <button type="button" class="btn btn-primary workorder-dashboard-total-change-option" data-id="custom_date_range" data-dismiss="modal">{{ trans('fi.save') }}</button>
                </div>
            </div>
        </div>
    </div>
</div>