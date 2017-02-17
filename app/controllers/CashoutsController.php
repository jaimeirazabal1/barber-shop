<?php

class CashoutsController extends \BaseController {

	/**
	 * Display a listing of cashouts
	 *
	 * @return Response
	 */
	public function index($company)
	{
        // TODO : verificar permisos para el corte de caja
        $store_id = Input::get('store', null);

        if (empty($store_id))
        {
            die('la sucursal no existe');
        }

		$cashouts = Cashout::byStore($store_id)->orderBy('created_at', 'desc')->paginate(20);
        $store    = Store::find($store_id);

		return View::make('cashouts.index', compact('cashouts', 'store_id', 'store'));
	}

	/**
	 * Show the form for creating a new cashout
	 *
	 * @return Response
	 */
	public function create($company)
	{
        // TODO : verificar permisos para el corte de caja
        $store_id = Input::get('store', null);

        if (empty($store_id))
        {
            die('la sucursal no existe');
        }

        $current_date = \Carbon\Carbon::now();

        $dayOfWeek = getDayOfWeek($current_date->dayOfWeek);

        # Horario en el que abre la sucursal
        $schedule = Schedule::byStore($store_id)->onDay($dayOfWeek)->first();

        # obtiene el último corte de caja
        $latest_cashout = Cashout::byStore($store_id)->latest()->first();

        if (empty($schedule))
        {
            Flash::error('No hay horario para este día');
            return Redirect::back();
        }

        # comprueba si ya existe un corte de caja, si no, toma el día de hoy desde que la sucursal abrió
        $last_cashout_date = empty($latest_cashout) ? ($current_date->toDateString() . ' ' . $schedule->opening ) : $latest_cashout->end->toDateTimeString();


        if ( empty($latest_cashout))
        {
            $date_start = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $last_cashout_date);
        }
        else
        {
            $date_start = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $last_cashout_date)->addSecond();
        }

        $date_end = $current_date;

        # Ventas pagadas del día a la fecha de corte
        $sales = Sale::with('appointment.services', 'products')->onDatetime($date_start->toDateTimeString(), $date_end->toDateTimeString())->paid()->byStore($store_id)->get();

        $total_sales = [
            'cash' => [
                'products' => 0,
                'services' => 0
            ],
            'card' => [
                'products' => 0,
                'services' => 0
            ]
        ];

        $tips = 0;

        // TODO : el precio de servicio debe ser almacenado en appointment_service ya que el precio puede cambiar
        foreach($sales as $sale)
        {
            $total_sale_services = 0;
            $total_sale_products = 0;

            # Valida que la cita tenga una cita válida
            if ( ! empty($sale->appointment))
            {
                foreach($sale->appointment->services as $service)
                {
                    $total_sale_services += $service->price;
                }
            }

            foreach($sale->products as $product)
            {
                $total_sale_products += ($product->pivot->price * $product->pivot->quantity);
            }

            switch($sale->type)
            {
                case 'cash':
                    $total_sales['cash']['products'] += $total_sale_products;
                    $total_sales['cash']['services'] += $total_sale_services;
                    break;
                case 'card':
                    $total_sales['card']['products'] += $total_sale_products;
                    $total_sales['card']['services'] += $total_sale_services;
                    break;
            }

            $tips += (empty($sale->tip) ? 0 : $sale->tip);
        }

        $total_cash = ($total_sales['cash']['products'] + $total_sales['cash']['services']);
        $total_card = ($total_sales['card']['products'] + $total_sales['card']['services']);

        # Ventas pendientes del día a la fecha de corte
        $sales_pending = Sale::onDatetime($date_start->toDateTimeString(), $date_end->toDateTimeString())->byStore($store_id)->pending()->get();

        $store = Store::find($store_id);


        return View::make('cashouts.create', compact('store_id', 'total_sales', 'sales', 'sales_pending', 'date_start', 'date_end', 'total_cash', 'total_card', 'store', 'latest_cashout', 'tips'));
	}

	/**
	 * Store a newly created cashout in storage.
	 *
	 * @return Response
	 */
	public function store($company)
	{
		$validator = Validator::make($data = Input::all(), Cashout::$rules);

		if ($validator->fails())
		{
            Flash::error(trans('messages.flash.error'));
			return Redirect::back()->withErrors($validator)->withInput();
		}

        $user = Session::get('user');

        $latest_cashout                = Cashout::byStore($data['store_id'])->latest()->first();

        $data['money_on_cash']         = (int) $data['money_on_cash'];
        $data['money_on_card']         = (int) $data['money_on_card'];
        $data['user_id']               = $user->id;
        $data['cash_left_on_register'] = convertMoneyToInteger($data['cash_left_on_register']);
        $data['withdraw']              = (($data['money_on_cash'] + $data['money_on_card']) - $data['cash_left_on_register']);
        $data['initial_register']      = empty($latest_cashout) ? 0 : $latest_cashout->cash_left_on_register;

        Cashout::create($data);

        Flash::success(trans('messages.flash.created'));
		return Redirect::route('cashout.index', [$company, 'store' => $data['store_id']]);
	}

	/**
	 * Display the specified cashout.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($company, $id)
	{
		$cashout = Cashout::findOrFail($id);

		return View::make('cashouts.show', compact('cashout'));
	}

	/**
	 * Show the form for editing the specified cashout.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($company, $id)
	{
		$cashout = Cashout::find($id);

		return View::make('cashouts.edit', compact('cashout'));
	}

	/**
	 * Update the specified cashout in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($company, $id)
	{
		$cashout = Cashout::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Cashout::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$cashout->update($data);

		return Redirect::route('cashouts.index');
	}

	/**
	 * Remove the specified cashout from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($company, $id)
	{
		Cashout::destroy($id);

		return Redirect::route('cashouts.index');
	}

    public function pdf($company)
    {
        $data = Input::all();

        $id = $data['cashout_id'];
        $store_id = $data['store_id'];

        $store   = Store::find($store_id);
        $cashout = Cashout::with('user')->find($id);

        #$data['cashout'] = $cashout;
        #$data['store']   = $store;

        $data = [
            'store' => $store->name,
            'start' => $cashout->start->format('Y-m-d H:i:s a'),
            'end' => $cashout->end->format('Y-m-d H:i:s a'),
            'cash' => $cashout->money_on_cash,
            'card' => $cashout->money_on_card,
            'total' => ($cashout->money_on_cash + $cashout->money_on_card),
            'withdraw' => $cashout->withdraw,
            'cash_left_on_register' => $cashout->cash_left_on_register,
            'initial_register' => $cashout->initial_register,
            'user' => $cashout->user->first_name . ' ' . $cashout->user->last_name,
            'tips' => $cashout->tips
        ];

        $pdf = PDF::loadView('cashouts.pdf.pdf', $data);

        return $pdf->download('corte-caja-' . $store->slug . '.pdf');
    }

}
