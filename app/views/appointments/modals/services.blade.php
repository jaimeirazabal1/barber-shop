
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3 class="modal-title"><strong>Búsqueda de servicios</strong></h3>
</div>
<div class="modal-body">


    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">

                <div class="panel panel-default">
                    <div class="panel-body">
                        <input type="text" class="form-control" id="services-table-filter" data-action="filter" data-filters="#services-table" placeholder="Buscar.." />
                    </div>
                    <table class="table table-hover" id="services-table">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Tiempo estimado</th>
                                <th>Precio</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($services as $service)
                            <tr>
                                <td>{{ $service->name }}<br><small class="label label-default">{{ $service->code }}</small></td>
                                <td>{{ $service->estimated_time }} min.</td>
                                <td>${{ convertIntegerToMoney($service->price) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>

        </div>
    </div>


</div>
<div class="modal-footer">


</div>
