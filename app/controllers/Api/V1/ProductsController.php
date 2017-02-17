<?php namespace Api\V1;
/**
 * Created by Apptitud.mx.
 * User: diegogonzalez
 * Date: 7/30/15
 * Time: 11:06 AM
 */

use \Api\ApiController;
use Barber\Repositories\Exceptions\ResourceNotFoundException;
use Barber\Repositories\Exceptions\ResourceOnCreateException;
use Barber\Repositories\Exceptions\Sort\SortableFieldInvalid;
use Barber\Repositories\Exceptions\Sort\SortableFieldNotAllowed;
use Barber\Repositories\Product\ProductRepository as Product;
use Barber\Transformers\ProductTransformer as ProductTransformer;
use Barber\Services\Paginator\Paginator as Paginator;
use Barber\Validators\Exceptions\ValidationException;
use Exception;
use \Input;
use Barber\Validators\Product\ProductValidator as Validator;

/**
 * Class ProductsController
 * @package Api\V1
 */
class ProductsController extends ApiController {

    /**
     * @var Product
     */
    private $product;

    /**
     * @var ProductTransformer
     */
    private $productTransformer;

    /**
     * @var Paginator
     */
    private $paginator;

    /**
     * @var Validator
     */
    private $validator;


    /**
     * @param Product $product
     * @param ProductTransformer $productTransformer
     * @param Paginator $paginator
     * @param Validator $validator
     */
    public function __construct(Product $product, ProductTransformer $productTransformer, Paginator $paginator, Validator $validator)
    {
        $this->product            = $product;
        $this->productTransformer = $productTransformer;
        $this->paginator          = $paginator;
        $this->validator          = $validator;
    }


    /**
     *
     */
    public function index()
    {
        $page    = Input::get('page', 1);
        $limit   = Input::get('limit', 10);
        $filter  = Input::get('filter', null);
        $company = Input::get('company', null);
        // TODO : agregar ?include=services,customers,etc
        $include = Input::get('include', null);


        $sortableFieldsAllowed = [
            'name',
            'price',
            'order'
        ];

        try {
            $sort = build_sortable_fields(Input::get('sort', null), $sortableFieldsAllowed);

            $params = [
                'sort'    => Input::get('sort', null),
                'filter'  => $filter,
                'company' => $company,
            ];

            $products    = $this->product->getByPage($page, $limit, $sort, $filter, $company);
            $pagination = $this->paginator->paginate($this->product->count(), $limit, $params);
        }
        catch(SortableFieldNotAllowed $e)
        {
            return $this->respondBadRequest($e->getMessage());
        }
        catch(SortableFieldInvalid $e)
        {
            return $this->respondBadRequest($e->getMessage());
        }
        catch(Exception $e)
        {
            return $this->respondInternalError();
        }

        return $this->respond([
            'pagination' => $pagination,
            'data'       => $this->productTransformer->transformCollection($products)
        ]);
    }

    /**
     *
     */
    public function store()
    {
        $data = getApiInput();

        try
        {
            $data['company_id'] = empty($data['company']['id']) ? null : $data['company']['id'];

            $this->validator->validateForCreate($data);

            $product = $this->product->create($data);
        }
        catch(ValidationException $e)
        {
            return $this->respondBadRequest($e->getErrors());
        }
        catch(ResourceOnCreateException $e)
        {
            return $this->respondInternalError('There was an error creating the product.');
        }
        catch(Exception $e)
        {
            return $this->respondInternalError();
        }

        return $this->respondCreated([
            'data' => $this->productTransformer->transform($product),
        ],
            [
                'location' => route('api.products.show', $product->id)
            ]
        );
    }

    /**
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        // TODO : agregar ?include=services,customers,etc
        try
        {
            $product = $this->product->getById($id);
        }
        catch(ResourceNotFoundException $e)
        {
            return $this->respondNotFound($e->getMessage());
        }
        catch(Exception $e)
        {
            return $this->respondInternalError();
        }

        return $this->respond([
            'data' => $this->productTransformer->transform($product)
        ]);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function update($id)
    {
        $data = getApiInput();

        try
        {
            $this->validator->validateForUpdate($id, $data);

            $product = $this->product->update($id, $data);
        }
        catch(ValidationException $e)
        {
            return $this->respondBadRequest($e->getErrors());
        }
        catch(Exception $e)
        {
            return $this->respondInternalError('There was an error updating the product.');
        }

        return $this->respond([
            'data' => $this->productTransformer->transform($product),
        ]);
    }

}