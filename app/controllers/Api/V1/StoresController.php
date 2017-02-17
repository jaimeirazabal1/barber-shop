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
use Barber\Repositories\Store\StoreRepository as Store;
use Barber\Transformers\StoreTransformer as StoreTransformer;
use Barber\Services\Paginator\Paginator as Paginator;
use Barber\Validators\Exceptions\ValidationException;
use Exception;
use \Input;
use Barber\Validators\Store\StoreValidator as Validator;

/**
 * Class CompaniesController
 * @package Api\V1
 */
class StoresController extends ApiController {

    /**
     * @var Store
     */
    private $store;

    /**
     * @var StoreTransformer
     */
    private $storeTransformer;

    /**
     * @var Paginator
     */
    private $paginator;

    /**
     * @var Validator
     */
    private $validator;


    /**
     * @param Store $store
     * @param StoreTransformer $storeTransformer
     * @param Paginator $paginator
     * @param Validator $validator
     */
    public function __construct(Store $store, StoreTransformer $storeTransformer, Paginator $paginator, Validator $validator)
    {
        $this->store              = $store;
        $this->storeTransformer   = $storeTransformer;
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
        // TODO : agregar ?include=company,etc
        $include = Input::get('include', null);


        /*$role = 'admin';

        switch($role)
        {
            case 'admin':
                # El administrador puede ver todos las sucursales de cualquier empresa
                break;
            case 'company':
                # La empresa, solo puede ver sus sucursales
                break;
            case 'store':
                # La sucursal, solo puede ver su sucursal
                break;
            case 'customer':
                # El cliente, puede ver todas las sucursales
                break;
            case 'barber':
                # El barbero, solo puede ver su sucursal
                break;
            case 'guest':
                # El invitado puede ver todas las sucursales
                break;
        }*/


        $sortableFieldsAllowed = [
            'name',
            'order'
        ];

        try {
            $sort = build_sortable_fields(Input::get('sort', null), $sortableFieldsAllowed);

            $params = [
                'sort'    => Input::get('sort', null),
                'filter'  => $filter,
                'company' => $company
            ];

            $barbers    = $this->store->getByPage($page, $limit, $sort, $filter, $company);
            $pagination = $this->paginator->paginate($this->store->count(), $limit, $params);
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
            'data'       => $this->storeTransformer->transformCollection($barbers)
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
            # ID de empresa al cual pertenece la sucursal
            $data['company_id'] = empty($data['company']['id']) ? null : $data['company']['id'];

            # Slug de la empresa, es único por empresa
            // TODO : Agregar servicio para generar slugs únicos
            $data['slug']    = \Str::slug($data['name']);

            $this->validator->validateForCreate($data);

            $store = $this->store->create($data);
        }
        catch(ValidationException $e)
        {
            return $this->respondBadRequest($e->getErrors());
        }
        catch(ResourceOnCreateException $e)
        {
            return $this->respondInternalError('There was an error creating the store.');
        }
        catch(Exception $e)
        {
            return $this->respondInternalError();
        }

        return $this->respondCreated([
            'data' => $this->storeTransformer->transform($store),
        ],
            [
                'location' => route('api.stores.show', $store->id)
            ]
        );
    }

    /**
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        // TODO : agregar ?include=company,etc
        try
        {
            $store = $this->store->getById($id);
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
            'data' => $this->storeTransformer->transform($store)
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
            # Slug de la empresa, único por empresa
            $data['slug'] = \Str::slug($data['name']);

            $this->validator->validateForUpdate($id, $data);

            $store = $this->store->update($id, $data);
        }
        catch(ValidationException $e)
        {
            return $this->respondBadRequest($e->getErrors());
        }
        catch(Exception $e)
        {
            return $this->respondInternalError('There was an error updating the store.');
        }

        return $this->respond([
            'data' => $this->storeTransformer->transform($store),
        ]);
    }

}