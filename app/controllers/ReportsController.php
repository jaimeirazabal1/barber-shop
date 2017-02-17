<?php
/**
 * Created by Apptitud.mx.
 * User: diegogonzalez
 * Date: 2/16/16
 * Time: 7:54 PM
 */

use \Carbon\Carbon;

/**
 * Class ReportsController
 */
class ReportsController extends \BaseController
{


	/**
	 * @param $company
	 */
	public function attendedCustomerCounter($company)
	{
		$data = Input::all();
		$company = Company::bySlug($company)->first();
		$stores = Store::with(['barbers'])->byCompany($company->id)->ordered()->get();
		$store_options = Store::byCompany($company->id)->ordered()->lists('name', 'id');
		$barber_options = Barber::byCompany($company->id)->ordered()->select(DB::raw("CONCAT(' ', first_name, last_name) as name, id"))->lists('name', 'id');
		$barber_options[''] = 'Elegir barbero';
		ksort($barber_options);
		$store_options[''] = 'Elegir sucursal';
		ksort($store_options);

		$date_start = empty($data['date_start']) ? date('Y-m-01') : Carbon::createFromFormat('Y-m-d', $data['date_start'])->toDateString();
		$date_end_temp = empty($data['date_end']) ? Carbon::now() : Carbon::createFromFormat('Y-m-d', $data['date_end']);
		$date_end = empty($data['date_end']) ? ($date_end_temp->format('Y-m-d')) : $date_end_temp->format('Y-m-d');
		$store_id = empty($data['store']) ? null : $data['store'];
		$barber_id = empty($data['barber']) ? null : $data['barber'];

		$bindings = [];
		$query = 'select count(appointments.id) as total, stores.id as store_id, stores.name as store_name, appointments.barber_id as barber_id, concat(" ", barbers.first_name, barbers.last_name) as barber_name
                  from appointments
                  inner join stores on stores.id = appointments.store_id ';

		# Filtro por sucursal
		if (!empty($store_id)) {
			$query .= ' and appointments.store_id = ? ';
			$bindings[] = $store_id;
		}

		$query .= ' inner join barbers on barbers.id = appointments.barber_id ';

		# Filtro por barbero
		if (!empty($barber_id)) {
			$query .= ' and appointments.barber_id = ? ';
			$bindings[] = $barber_id;
		}

		$query .= ' where date(appointments.start) between ? and ? ';

		$bindings[] = $date_start;
		$bindings[] = $date_end;

		$query .= ' and appointments.status = ? ';
		$bindings[] = 'completed';

		$query .= ' group by appointments.store_id
                    ,appointments.barber_id';

		$results = \DB::select($query, $bindings);

		$data_results = [];


		foreach ($results as $result) {
			$data_results[$result->store_id]['info'] = [
				'name' => $result->store_name,
			];

			$data_results[$result->store_id]['barbers'][$result->barber_id] = [
				'total' => $result->total,
				'name' => $result->barber_name
			];
		}

		return View::make('reports.numero-clientes-atendidos', compact('store_options', 'barber_options', 'date_start', 'date_end', 'barber_id', 'store_id', 'results', 'stores', 'data_results'));
	}

	/**
	 * @param $company
	 */
	public function servicesByDay($company)
	{
		$data = Input::all();
		$company = Company::bySlug($company)->first();
		$stores = Store::with(['barbers'])->byCompany($company->id)->ordered()->get();
		$store_options = Store::byCompany($company->id)->ordered()->lists('name', 'id');
		$barber_options = Barber::byCompany($company->id)->ordered()->select(DB::raw("CONCAT(' ', first_name, last_name) as name, id"))->lists('name', 'id');
		$barber_options[''] = 'Elegir barbero';
		ksort($barber_options);
		$store_options[''] = 'Elegir sucursal';
		ksort($store_options);

		$date_start = empty($data['date_start']) ? date('Y-m-01') : Carbon::createFromFormat('Y-m-d', $data['date_start'])->toDateString();
		$date_end_temp = empty($data['date_end']) ? Carbon::now() : Carbon::createFromFormat('Y-m-d', $data['date_end']);
		$date_end = empty($data['date_end']) ? ($date_end_temp->format('Y-m-d')) : $date_end_temp->format('Y-m-d');
		$store_id = empty($data['store']) ? null : $data['store'];
		$barber_id = empty($data['barber']) ? null : $data['barber'];

		$bindings = [];
		$query = 'select distinct(date(appointments.start)) as dia, count(services.id) as total
                    from appointments
                    inner join appointment_service on appointment_service.appointment_id = appointments.id
                    inner join services on services.id = appointment_service.service_id
                    inner join barbers on barbers.id = appointments.barber_id ';

		#-- Filtro por Barbero
		if (!empty($barber_id)) {
			$query .= ' and barbers.id = ? ';
			$bindings[] = $barber_id;
		}

		$query .= ' inner join stores on stores.id = appointments.store_id ';

		# -- Filtro por sucursal
		if (!empty($store_id)) {
			$query .= ' and stores.id = ? ';
			$bindings[] = $store_id;
		}

		$query .= ' where date(appointments.start) between ? and ? ';
		$bindings[] = $date_start;
		$bindings[] = $date_end;

		$query .= ' and appointments.status = ? ';
		$bindings[] = 'completed';

		$query .= ' group by dia order by dia asc';

		$results = \DB::select($query, $bindings);

		$data_results = [];

		$carbon_start_date = \Carbon\Carbon::createFromFormat('Y-m-d', $date_start);
		$carbon_end_date = \Carbon\Carbon::createFromFormat('Y-m-d', $date_end);

		while ($carbon_start_date->timestamp < $carbon_end_date->timestamp) {
			$date = $carbon_start_date->format('Y-m-d');

			$data_results[$date]['total'] = 0;

			$carbon_start_date->addDay();
		}

		foreach ($results as $result) {
			$data_results[$result->dia]['total'] = $result->total;
		}

		return View::make('reports.servicios-por-dia', compact('store_options', 'barber_options', 'date_start', 'date_end', 'barber_id', 'store_id', 'results', 'stores', 'data_results'));
	}

	/**
	 * @param $company
	 */
	public function salesAmountByService($company)
	{
		$data = Input::all();
		$company = Company::bySlug($company)->first();
		$stores = Store::with(['barbers'])->byCompany($company->id)->ordered()->get();
		$store_options = Store::byCompany($company->id)->ordered()->lists('name', 'id');
		$barber_options = Barber::byCompany($company->id)->ordered()->select(DB::raw("CONCAT(' ', first_name, last_name) as name, id"))->lists('name', 'id');
		$barber_options[''] = 'Elegir barbero';
		ksort($barber_options);
		$store_options[''] = 'Elegir sucursal';
		ksort($store_options);

		$date_start = empty($data['date_start']) ? date('Y-m-01') : Carbon::createFromFormat('Y-m-d', $data['date_start'])->toDateString();
		$date_end_temp = empty($data['date_end']) ? Carbon::now() : Carbon::createFromFormat('Y-m-d', $data['date_end']);
		$date_end = empty($data['date_end']) ? ($date_end_temp->format('Y-m-d')) : $date_end_temp->format('Y-m-d');
		$store_id = empty($data['store']) ? null : $data['store'];
		$barber_id = empty($data['barber']) ? null : $data['barber'];

		$bindings = [];
		$query = 'select ifnull(sum(sales.total), 0) as total, sales.store_id as store_id, barbers.id as barber_id, sales.type as type_sale
                  from sales
                  inner join stores on stores.id = sales.store_id ';

		if (!empty($store_id)) {
			$query .= ' and stores.id = ? ';
			$bindings[] = $store_id;
		}

		$query .= ' inner join appointments on appointments.id = sales.appointment_id
                    inner join barbers on barbers.id = appointments.barber_id ';

		if (!empty($barber_id)) {
			$query .= ' and barbers.id = ? ';
			$bindings[] = $barber_id;
		}

		$query .= ' where sales.appointment_id is not null
                    and date(sales.created_at) between ? and ? ';
		$bindings[] = $date_start;
		$bindings[] = $date_end;

		$query .= ' and sales.status = ? ';
		$bindings[] = 'paid';

		$query .= ' group by sales.store_id, barbers.id, sales.type';

		$results = \DB::select($query, $bindings);

		$data_results = [];

		foreach ($results as $result) {
			$data_results[$result->store_id]['barbers'][$result->barber_id][$result->type_sale] = $result->total;
		}

		return View::make('reports.importe-de-ventas-de-servicios', compact('store_options', 'barber_options', 'date_start', 'date_end', 'barber_id', 'store_id', 'results', 'stores', 'data_results'));
	}

	/**
	 * @param $company
	 */
	public function salesAmountByProduct($company)
	{
		$data = Input::all();
		$company = Company::bySlug($company)->first();
		$stores = Store::with(['barbers'])->byCompany($company->id)->ordered()->get();
		$store_options = Store::byCompany($company->id)->ordered()->lists('name', 'id');
		$barber_options = Barber::byCompany($company->id)->ordered()->select(DB::raw("CONCAT(' ', first_name, last_name) as name, id"))->lists('name', 'id');
		$barber_options[''] = 'Elegir barbero';
		ksort($barber_options);
		$store_options[''] = 'Elegir sucursal';
		ksort($store_options);

		$date_start = empty($data['date_start']) ? date('Y-m-01') : Carbon::createFromFormat('Y-m-d', $data['date_start'])->toDateString();
		$date_end_temp = empty($data['date_end']) ? Carbon::now() : Carbon::createFromFormat('Y-m-d', $data['date_end']);
		$date_end = empty($data['date_end']) ? ($date_end_temp->format('Y-m-d')) : $date_end_temp->format('Y-m-d');
		$store_id = empty($data['store']) ? null : $data['store'];
		$barber_id = empty($data['barber']) ? null : $data['barber'];

		$bindings = [];
		$query = 'select ifnull(sum(product_sale.price * product_sale.quantity), 0) as total, sales.store_id as store_id, sales.type as type_sale
                    from sales
                    inner join product_sale on product_sale.sale_id = sales.id
                    inner join stores on stores.id = sales.store_id -- and stores.id = 1 -- filtro por sucursal
                    where date(sales.created_at) between ? and ? ';
		$bindings[] = $date_start;
		$bindings[] = $date_end;

		$query .= ' and sales.status = ? ';
		$bindings[] = 'paid';

		$query .= ' group by sales.store_id, sales.type';

		$results = \DB::select($query, $bindings);

		$data_results = [];

		foreach ($results as $result) {
			$data_results[$result->store_id][$result->type_sale] = $result->total;
		}

		return View::make('reports.importe-de-ventas-de-productos', compact('store_options', 'barber_options', 'date_start', 'date_end', 'barber_id', 'store_id', 'results', 'stores', 'data_results'));
	}

	/**
	 * @param $company
	 */
	public function bestProductSellers($company)
	{
		$data = Input::all();
		$company = Company::bySlug($company)->first();
		$stores = Store::with(['barbers'])->byCompany($company->id)->ordered()->get();
		$store_options = Store::byCompany($company->id)->ordered()->lists('name', 'id');
		$barber_options = Barber::byCompany($company->id)->ordered()->select(DB::raw("CONCAT(' ', first_name, last_name) as name, id"))->lists('name', 'id');
		$barber_options[''] = 'Elegir barbero';
		ksort($barber_options);
		$store_options[''] = 'Elegir sucursal';
		ksort($store_options);

		$date_start = empty($data['date_start']) ? date('Y-m-01') : Carbon::createFromFormat('Y-m-d', $data['date_start'])->toDateString();
		$date_end_temp = empty($data['date_end']) ? Carbon::now() : Carbon::createFromFormat('Y-m-d', $data['date_end']);
		$date_end = empty($data['date_end']) ? ($date_end_temp->format('Y-m-d')) : $date_end_temp->format('Y-m-d');
		$store_id = empty($data['store']) ? null : $data['store'];
		$barber_id = empty($data['barber']) ? null : $data['barber'];

		$bindings = [];
		$query = 'select
                    products.id as product_id,
                    products.name as product_name, products.sku as product_sku,
                    product_store.stock as product_stock,
                    sum(product_sale.quantity) as product_sales
                    from products
                    inner join product_store on product_store.product_id = products.id ';

		# -- Filtro por sucursal
		if (!empty($store_id)) {
			$query .= ' and product_store.store_id = ? ';
			$bindings[] = $store_id;
		}

		$query .= ' inner join product_sale on product_sale.product_id = products.id
                    inner join sales on sales.id = product_sale.sale_id ';

		$query .= ' where date(sales.created_at) between ? and ? ';

		$bindings[] = $date_start;
		$bindings[] = $date_end;

		$query .= ' group by products.id
                    order by product_sales desc';

		$results = \DB::select($query, $bindings);

		return View::make('reports.productos-mas-vendidos', compact('store_options', 'barber_options', 'date_start', 'date_end', 'barber_id', 'store_id', 'results', 'stores'));
	}

	public function generate($company)
	{
		return View::make('reports.generate', compact([]));
	}  // end method

	public function show($company)
	{
		return $_GET;
//        return View::make('reports.generate', compact( [] ));
	}  // end method

	/**
	 * @param $company
	 */
	public function averageTimeByService($company)
	{
		$data = Input::all();
		$company = Company::bySlug($company)->first();
		$stores = Store::with(['barbers'])->byCompany($company->id)->ordered()->get();
		$store_options = Store::byCompany($company->id)->ordered()->lists('name', 'id');
		$barber_options = Barber::byCompany($company->id)->ordered()->select(DB::raw("CONCAT(' ', first_name, last_name) as name, id"))->lists('name', 'id');
		$barber_options[''] = 'Elegir barbero';
		ksort($barber_options);
		$store_options[''] = 'Elegir sucursal';
		ksort($store_options);

		$date_start = empty($data['date_start']) ? date('Y-m-01') : Carbon::createFromFormat('Y-m-d', $data['date_start'])->toDateString();
		$date_end_temp = empty($data['date_end']) ? Carbon::now() : Carbon::createFromFormat('Y-m-d', $data['date_end']);
		$date_end = empty($data['date_end']) ? ($date_end_temp->format('Y-m-d')) : $date_end_temp->format('Y-m-d');
		$store_id = empty($data['store']) ? null : $data['store'];
		$barber_id = empty($data['barber']) ? null : $data['barber'];

		$bindings = [];
		$query = 'select appointments.id as appointment, services.id as service, services.name, services.estimated_time, sales.checkin, sales.checkout, TIMESTAMPDIFF(MINUTE,sales.checkin, sales.checkout) as final_time
                    from appointments
                    inner join appointment_service on appointments.id = appointment_service.appointment_id
                    inner join services on services.id = appointment_service.service_id
                    inner join sales on sales.appointment_id = appointments.id ';

		$date_start = '2016-01-01';
		$date_end = '2016-02-29';

		$query .= ' where date(appointments.start) between ? and ? ';
		$bindings[] = $date_start;
		$bindings[] = $date_end;

		$query .= ' and appointments.status = ? ';
		$bindings[] = 'completed';

		#-- Filtro por Barbero
		if (!empty($barber_id)) {
			$query .= ' and appointments.barber_id = ? ';
			$bindings[] = $barber_id;
		}

		$results = \DB::select($query, $bindings);

		$data_results = [];

		// Agrupar por cita
		foreach ($results as $result) {
			$data_results[$result->appointment][$result->service] = $result;
		}

		// Agrupa por mismos servicios
		foreach ($results as $result) {
			$data_results[$result->appointment][$result->service] = $result;
		}


		return $data_results;

		return View::make('reports.tiempo-promedio-por-servicio', compact('store_options', 'barber_options', 'date_start', 'date_end', 'barber_id', 'store_id', 'results', 'stores', 'data_results'));
	}

	/**
	 * @param $company
	 */
	function inventory($company)
	{
		$company = Company::bySlug($company)->first();
		$products = Product::with('category', 'stores', 'tags')->byCompany($company->id)->orderBy('category_id')->get();
//		$sucursal0 = [];
//		$sucursal1 = [];
//		foreach ($products as $product) {
//			if( $product -> stores -> id == 1 )
//				return $product -> stores;
//			else
//				return $product -> stores;
//		}   // end foreach
//		unset($product);
//		return $products;
		return View::make('reports.inventory', compact('products'));
	}

}