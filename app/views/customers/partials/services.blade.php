<div class="col-md-5">
    <!-- Block -->
    <div class="block">

        <!-- Horizontal Form Title -->
        <div class="block-title">
            <h2>Servicios</h2>
            <!--div class="block-options pull-right">
                <a href="{{ route('barbers.index', $company) }}" class="btn btn-effect-ripple btn-default" data-toggle="tooltip" title="" style="overflow: hidden; position: relative;" data-original-title="Agregar servicio"><i class="fa fa-plus-circle"></i> Agregar</a>
            </div-->
        </div>
        <!-- END Horizontal Form Title -->

        <!-- Form Content -->
        {{ Form::open(array('method' => 'POST', 'route' => array('customers.services.store', $company), 'class' => 'form-bordered', 'data-services-store'))  }}


        {{-- Servicios -  SELECT2 --}}
        <div class="form-group {{ $errors->first('services') ? 'has-error' : '' }}">
            {{ Form::select('services_options', $services, null, array('class' => 'select-select2', 'placeholder' => '', 'data-placeholder' => 'Servicios disponibles', 'style' => 'width: 70%;', 'id' => 'services_options', 'data-service-options' => '')) }}
            <a data-add-service href="#" class="btn btn-effect-ripple btn-success" data-toggle="tooltip" title="" style="overflow: hidden; position: relative; width: 25%;" data-original-title="Agregar servicio"><i class="fa fa-plus-circle"></i> Agregar</a>
        </div>

        <br />
        <br />
        <br />


        {{-- SLIDER CONTEXTUAL --}}

        {{--<div class="form-group">
            <p class="text-muted">
                <label class="">
                    Afeitado
                </label>
                <a class="pull-right btn btn-danger btn-xs" data-toggle="tooltip" title="Eliminar"><i class="fa fa-times"></i></a>
            </p>
            <div class="input-slider-info">
                <input type="text" id="example-slider-context4" name="example-slider-context4" class="form-control input-slider" data-slider-min="0" data-slider-max="100" data-slider-step="1" data-slider-value="80" data-slider-orientation="horizontal" data-slider-selection="before" data-slider-tooltip="show">
            </div>
        </div>
        --}}


        <span data-service-before-insert></span>

        {{-- FORM ACTIONS --}}
        <!--div  class="form-group form-actions">
            {{ Form::submit('Guardar servicios', array('class' => 'btn btn-sm btn-effect-ripple btn-info')) }}
        </div-->

        {{ Form::close() }}
        <!-- END Form Content -->


    </div>
    <!-- END Block -->

</div>