<?php

class ProductsController extends \BaseController
{

	/**
	 * Display a listing of products
	 *
	 * @return Response
	 */
	public function index($company)
	{
//        $query = isset( $_GET[ 'q' ] ) ? null : $_GET[ 'q' ];
//
//        if( $query ) {
//            return $query;
//        }   // end if

		if (isset($_GET['q'])) {

			$company = Company::bySlug($company)->first();
			$category = CategoryProduct::where('name', $_GET['q'])->orWhere( 'slug', $_GET['q'] )->first();
			$tag = TagProduct::where('name', $_GET['q'])->orWhere( 'slug', $_GET['q'] )->first();
			if( isset( $category ->id ) ) {
				$products = Product::with('category', 'stores', 'tags')->where('category_id', $category ->id)->byCompany($company->id)->paginate(40);
				return View::make('products.index', compact('products'));
			}   // end if
			elseif( isset( $tag ->id ) ) {
				$store = [];

//				SELECT product_id FROM barbershop.product_tag_product WHERE tag_product_id = 1;
				$query = DB::table( 'product_tag_product' )->select( 'product_id' )->where( 'tag_product_id', $tag->id )->get();
				foreach( $query as $value ) {
					array_push( $store, $value -> product_id );
				}   // end foreach
				unset( $value );
//				return $store;
				$products = Product::with('category', 'stores', 'tags')->whereIn('id', $store)->byCompany($company->id)->paginate(40);
				return View::make('products.index', compact('products'));
			}   // end elseif

			$products = Product::with('category', 'stores', 'tags')->filter($_GET['q'])->byCompany($company->id)->paginate(20);
			return View::make('products.index', compact('products'));
		}   // end if

		$company = Company::bySlug($company)->first();
		$products = Product::with('category', 'stores', 'tags')->byCompany($company->id)->paginate(20);
		return View::make('products.index', compact('products'));
	}

	/**
	 * Show the form for creating a new product
	 *
	 * @return Response
	 */
	public function create($company)
	{
		$company = Company::bySlug($company)->first();
		$categories = $this->categories($company->id);
		$suppliers = $this->suppliers($company->id);
		$tags = $this->tags($company->id);
		$stores = Store::byCompany($company->id)->get();
		$stock = [];

		return View::make('products.create', compact('company', 'categories', 'suppliers', 'tags', 'stores', 'stock'));
	}

	// TODO : Agregar transacciones para los inventarios
	/**
	 * Store a newly created product in storage.
	 *
	 * @return Response
	 */
	public function store($company)
	{
		$company = Company::bySlug($company)->first();
		$validator = Validator::make($data = Input::all(), [
			'name' => 'required',
			'sku' => '',
			'price' => 'required|money',
			'image' => 'image',
			'active' => '',
			'order' => 'integer',
			'company_id' => '',
			'supplier_id' => 'integer',
			'category_id' => 'integer',
		]);

		if ($validator->fails()) {
			Flash::error(trans('messages.flash.error'));
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$data['active'] = empty($data['active']) ? false : true;
		$data['supplier_id'] = empty($data['supplier_id']) ? null : $data['supplier_id'];
		$data['category_id'] = empty($data['category_id']) ? null : $data['category_id'];

		if (!empty($data['image'])) {
			$uploader = new App\Services\Uploader\Upload;
			$file = $uploader->save('image');
			$filePath = $file->getPath() . $file->getName();
			$data['image'] = $filePath;
		}


		$data['price'] = convertMoneyToInteger($data['price']);
		$data['company_id'] = $company->id;

		$product = Product::create($data);

		if (!empty($data['tags'])) {
			$product->tags()->sync($data['tags']);
		}

		// Inventario
		if (!empty($data['stores'])) {
			$dataServices = array();
			foreach ($data['stores'] as $serviceKey => $servicePercent) {
				$dataServices = array_add($dataServices, $serviceKey, array('stock' => empty($servicePercent) ? 0 : $servicePercent));
			}

			$product->stores()->sync($dataServices);
		}


		Flash::success(trans('messages.flash.created'));
		return Redirect::route('products.index', $company->slug);
	}


	/**
	 * Show the form for editing the specified product.
	 *
	 * @param  int $id
	 * @return Response
	 */
	public function edit($company, $id)
	{
		$company = Company::bySlug($company)->first();
		$product = Product::with('tags', 'stores')->find($id);
		$categories = $this->categories($company->id);
		$suppliers = $this->suppliers($company->id);
		$tags = $this->tags($company->id);
		$stores = Store::byCompany($company->id)->get();
		$tagsSelected = empty($product->tags) ? null : $product->tags->lists('id');

		$stock = [];

		foreach ($product->stores as $store) {
			$stock[$store->id] = empty($store->pivot) ? 0 : $store->pivot->stock;
		}

		return View::make('products.edit', compact('product', 'categories', 'suppliers', 'tags', 'tagsSelected', 'stores', 'stock'));
	}

	// TODO : agregar transacciones para los inventarios
	/**
	 * Update the specified product in storage.
	 *
	 * @param  int $id
	 * @return Response
	 */
	public function update($company, $id)
	{
		$company = Company::bySlug($company)->first();
		$product = Product::findOrFail($id);

		$validator = Validator::make($data = Input::all(), [
			'name' => 'required',
			'sku' => '',
			'price' => 'required|money',
			'image' => 'image',
			'supplier_id' => 'integer',
			'category_id' => 'integer',
			'active' => '',
			'order' => 'integer'
		]);

		if ($validator->fails()) {
			Flash::error(trans('messages.flash.error'));
			return Redirect::back()->withErrors($validator)->withInput();
		}

		if (!empty($data['image'])) {
			if (File::exists(public_path() . $product->image)) {
				File::delete(public_path() . $product->image);
			}

			$uploader = new App\Services\Uploader\Upload;
			$file = $uploader->save('image');
			$filePath = $file->getPath() . $file->getName();
			$data['image'] = $filePath;
		} else {
			$data = array_except($data, 'image');
		}

		$data['active'] = empty($data['active']) ? false : true;
		$data['price'] = convertMoneyToInteger($data['price']);
		$data['company_id'] = $company->id;
		$data['supplier_id'] = empty($data['supplier_id']) ? null : $data['supplier_id'];
		$data['category_id'] = empty($data['category_id']) ? null : $data['category_id'];

		$data['tags'] = empty($data['tags']) ? array() : $data['tags'];
		$product->tags()->sync($data['tags']);

		// Inventario
		if (!empty($data['stores'])) {
			$dataServices = array();
			foreach ($data['stores'] as $serviceKey => $servicePercent) {
				$dataServices = array_add($dataServices, $serviceKey, array('stock' => empty($servicePercent) ? 0 : $servicePercent));
			}

			$product->stores()->sync($dataServices);
		}


		$product->update($data);

		Flash::success(trans('messages.flash.updated'));
		return Redirect::route('products.index', $company->slug);
	}


	private function categories($company_id)
	{
		$categories = CategoryProduct::where('company_id', $company_id)->lists('name', 'id');
		$categories[''] = 'Selecciona una categoría';
		ksort($categories);

		return $categories;
	}


	private function suppliers($company_id)
	{
		$suppliers = Supplier::where('company_id', $company_id)->lists('name', 'id');
		$suppliers[''] = 'Selecciona un proveedor';
		ksort($suppliers);

		return $suppliers;
	}

	private function tags($company_id)
	{
		$tags = TagProduct::where('company_id', $company_id)->orderBy('name', 'asc')->lists('name', 'id');

		return $tags;
	}


}