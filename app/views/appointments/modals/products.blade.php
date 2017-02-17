
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3 class="modal-title"><strong>Búsqueda de productos</strong></h3>
</div>
<div class="modal-body">


    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">

                <div class="panel panel-default">
                    <div class="panel-body">
                        <input type="text" class="form-control" id="products-table-filter" data-action="filter" data-filters="#products-table" placeholder="Buscar.." />
                    </div>
                    <table class="table table-hover" id="products-table">
                        <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Existencias</th>
                            <th>Precio</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($products as $product)
                            <tr>
                                <td>{{ $product->name }}<br><small class="label label-default">{{ $product->sku }}</small></td>
                                <td>
                                    @foreach($product->stores as $store)
                                        {{ $store->pivot->stock }}
                                    @endforeach
                                </td>
                                <td>${{ convertIntegerToMoney($product->price) }}</td>
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
