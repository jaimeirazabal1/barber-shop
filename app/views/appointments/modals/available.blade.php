
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3 class="modal-title"><strong>Citas disponibles </strong></h3>
</div>
<div class="modal-body">


    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">

                @foreach($data as $day)
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <td colspan="4"><span class="label label-info">{{ $day['info'] }}</span></td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <table class="table table-hover">
                                    <thead>
                                        <tr><td>&nbsp;</td></tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $start_appointments = \Carbon\Carbon::createFromFormat('H:i:s', $store->start_appointments);
                                            $end_appointments   = \Carbon\Carbon::createFromFormat('H:i:s', $store->end_appointments);
                                        ?>

                                        <?php while($start_appointments->timestamp < $end_appointments->timestamp) : ?>
                                            <tr><td>{{ $start_appointments->format('g:i a') }}</td></tr>
                                            <?php $start_appointments->addMinutes(30); ?>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                            </td>
                            @foreach($day['barbers'] as $barber)
                            <td>
                                <table class="table">
                                    <thead>
                                        <tr><td>{{ $barber['info']['name'] }}</td></tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $start_appointments_barber = \Carbon\Carbon::createFromFormat('H:i:s', $store->start_appointments);
                                        $end_appointments_barber   = \Carbon\Carbon::createFromFormat('H:i:s', $store->end_appointments);
                                        ?>
                                        <?php while($start_appointments_barber->timestamp < $end_appointments_barber->timestamp) : ?>
                                            <tr>
                                                <?php $time = $start_appointments_barber->format('H:i'); ?>

                                                @if (in_array($time, $barber['schedule']))
                                                    @if(in_array($time, $barber['booked']))
                                                        <td class="danger">No disponible</td>
                                                    @else
                                                        <td class="success">Disponible</td>
                                                    @endif
                                                @else
                                                    <td class="">-</td>
                                                @endif

                                            </tr>
                                            <?php $start_appointments_barber->addMinutes(30); ?>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                            </td>
                            @endforeach
                        </tr>
                    </tbody>
                </table>
                @endforeach

            </div>
        </div>
    </div>


</div>
<div class="modal-footer">


</div>
