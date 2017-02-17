@extends('layouts.master')


@section('title', 'Nómina')
@section('module', 'NÓMINA')


@section('content')

<!-- Section Header -->
<div class="content-header">
    <div class="row">
        <div class="col-sm-6">
            <div class="header-section">
                <h1>Nómina  <small class="label label-info">
                                {{ $date_start->format('d') }}/
                                {{ getMonth($date_start->format('n')) }}/
                                {{ $date_start->format('Y') }}
                            </small>
                            <small> - </small>
                            <small class="label label-info">
                                {{ $date_end->format('d') }}/
                                {{ getMonth($date_end->format('n')) }}/
                                {{ $date_end->format('Y') }}
                            </small>
                </h1>
            </div>
        </div>
        <div class="col-sm-6 hidden-xs">
            <div class="header-section">
                <ul class="breadcrumb breadcrumb-top">
                    <li>{{ link_to_route('admin.dashboard', 'Dashboard') }}</li>
                    <li>Nómina</li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- END Section Header -->

<!-- Tables Row -->
<div class="row">
    <div class="col-lg-12">
        @foreach($payroll->stores as $store)
        <!-- Partial Responsive Block -->
        <div class="block">
            <!-- Partial Responsive Title -->
            <div class="block-title">
                <h2>Sucursal {{ $store->name }}</h2>
                <div class="block-options pull-right">
                    {{--<a href="{{ route('admin.payroll.create') }}" class="btn btn-effect-ripple btn-success" data-toggle="tooltip" title="" style="overflow: hidden; position: relative;" data-original-title="Agregar registro"><i class="fa fa-plus"></i> Agregar</a>--}}
                </div>
            </div>
            <!-- END Partial Responsive Title -->
            @if(count($store->barbers))
            <table class="table table-striped table-borderless table-vcenter">
                <thead>
                    <tr>
                        <th></th>
                        <?php $daysBackwards = 0; ?>

                        @while($date_start->timestamp <= $date_end->timestamp)
                            <th valign="top" class="text-center">
                                {{ getDay($date_start->dayOfWeek) }}<br/><small class="label label-default">{{ $date_start->format('d') }}</small>
                            </th>
                            <?php
                                $date_start->addDay();
                                $daysBackwards++;
                            ?>
                        @endwhile

                        <?php $date_start->subDays($daysBackwards); ?>

                        <th valign="top">Ventas<br /><small>&nbsp;</small></th>
                        <th valign="top">Resúmen<br /><small>&nbsp;</small></th>
                        <th valign="top" class="text-right">Total<br /><small>&nbsp;</small></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($store->barbers as $barber)
                        @if ($barber->active)
                            <tr>
                                <td><strong>{{ $barber->first_name }} {{ $barber->last_name }}</strong></td>

                                <?php
                                    $daysBackwards = 0;
                                    $presentDays = 0;
                                    $absenceDays = 0;
                                    $retardmentDays = 0;
                                    $excusedAbsenceDays = 0;
                                    $vacationDays = 0;
                                ?>

                                @while($date_start->timestamp <= $date_end->timestamp)
                                    <td>
                                    <?php
                                        $checkin = empty($checkin_barbers[$barber->id][$date_start->format('d')]) ? null : $checkin_barbers[$barber->id][$date_start->format('d')];
                                    ?>

                                    @if ($checkin)
                                            @if ($checkin['checkin']->status == 'present')
                                                <span class="label label-success">{{ getCheckinStatus($checkin['checkin']->status) }}</span>
                                                <?php $presentDays++; ?>
                                            @elseif ($checkin['checkin']->status == 'absence')
                                                <span class="label label-danger">{{ getCheckinStatus($checkin['checkin']->status) }}</span>
                                                <?php $absenceDays++; ?>
                                            @elseif ($checkin['checkin']->status == 'retardment')
                                                <span class="label label-warning">{{ getCheckinStatus($checkin['checkin']->status) }}</span>
                                                <?php $retardmentDays++; ?>
                                            @elseif ($checkin['checkin']->status == 'excused_absence')
                                                <span class="label label-default">{{ getCheckinStatus($checkin['checkin']->status) }}</span>
                                                <?php $excusedAbsenceDays++; ?>
                                            @elseif ($checkin['checkin']->status == 'vacation')
                                                <span class="label label-default">{{ getCheckinStatus($checkin['checkin']->status) }}</span>
                                                <?php $vacationDays++; ?>
                                            @endif
                                    @else
                                            <span class="label label-danger">{{ getCheckinStatus('absence') }}</span>
                                            <?php $absenceDays++; ?>
                                    @endif
                                    </td>

                                    <?php
                                    $date_start->addDay();
                                    $daysBackwards++;
                                    ?>
                                @endwhile

                                <?php $date_start->subDays($daysBackwards); ?>

                                <td>
                                    <small><i class="fa fa-dollar"></i>{{ convertIntegerToMoney($checkin_barbers[$barber->id]['services']) }}</small>
                                </td>
                                <td>
                                    <?php $commission_percent = 0; ?>
                                    @foreach($commissions as $commission)
                                        @if ($checkin_barbers[$barber->id]['services'] >= $commission->min and $checkin_barbers[$barber->id]['services'] <= $commission->max)
                                            <?php
                                                $commission_percent = $commission->percent;
                                                break;
                                            ?>
                                        @endif
                                    @endforeach

                                    <?php $commissions_percent_barber = 0; ?>

                                        @if ($commission_percent > 0)
                                            <?php
                                                $commissions_percent_barber = ($commission_percent - $absenceDays);
                                                $commissions_percent_barber = ($commissions_percent_barber - $retardmentDays);
                                            ?>
                                        @endif

                                    <small class="label label-default">{{ $commissions_percent_barber }}% comisiones</small><br />
                                    <small class="label label-default">{{ $presentDays }} asistencias</small><br />
                                    <small class="label label-default">{{ $absenceDays }} faltas</small><br />
                                    <small class="label label-default">{{ $retardmentDays }} retardos</small><br />
                                    <small class="label label-default">{{ $excusedAbsenceDays }} faltas justificadas</small><br />
                                    <small class="label label-default">{{ $vacationDays }} vacaciones</small><br />
                                </td>
                                <td align="right">
                                    <?php
                                        $salary_barber = calculateSalaryBarber($barber->salary, 6, $absenceDays);
                                        $commission_by_sales = calculateTotalCommissions($commissions_percent_barber, $checkin_barbers[$barber->id]['services']);
                                    ?>
                                    <small class="text-muted">Comisiones:</small> <span class="label label-default"><i class="fa fa-dollar"></i>{{ convertIntegerToMoney($commission_by_sales) }}</span><br />
                                    <small class="text-muted">Sueldo:</small> <span class="label label-default"><i class="fa fa-dollar"></i>{{ convertIntegerToMoney($salary_barber) }}</span><br />
                                    <span class="label label-info"><i class="fa fa-dollar"></i>{{ convertIntegerToMoney($salary_barber + $commission_by_sales) }}</span>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
            @else
                <p>No hay barberos registrados.</p>
            @endif
        </div>
        <!-- END Partial Responsive Block -->

        @endforeach


    </div>

</div>
<!-- END Tables Row -->


@stop


@section('javascript')

@stop