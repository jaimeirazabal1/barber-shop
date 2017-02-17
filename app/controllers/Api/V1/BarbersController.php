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
use Barber\Repositories\Barber\BarberRepository as Barber;
use Barber\Transformers\BarberTransformer as BarberTransformer;
use Barber\Services\Paginator\Paginator as Paginator;
use Barber\Validators\Exceptions\ValidationException;
use Exception;
use \Input;
use Barber\Validators\Barber\BarberValidator as Validator;

/**
 * Class BarbersController
 * @package Api\V1
 */
class BarbersController extends ApiController {

    /**
     * @var Barber
     */
    private $barber;

    /**
     * @var BarberTransformer
     */
    private $barberTransformer;

    /**
     * @var Paginator
     */
    private $paginator;

    /**
     * @var Validator
     */
    private $validator;


    /**
     * @param Barber $barber
     * @param BarberTransformer $barberTransformer
     * @param Paginator $paginator
     * @param Validator $validator
     */
    public function __construct(Barber $barber, BarberTransformer $barberTransformer, Paginator $paginator, Validator $validator)
    {
        $this->barber              = $barber;
        $this->barberTransformer   = $barberTransformer;
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
        $store   = Input::get('store', null);
        // TODO : agregar ?include=services,customers,etc
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
            case 'barber':
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
            'first_name',
            'last_name'
        ];

        try {
            $sort = build_sortable_fields(Input::get('sort', null), $sortableFieldsAllowed);

            $params = [
                'sort'    => Input::get('sort', null),
                'filter'  => $filter,
                'company' => $company,
                'store'   => $store
            ];

            $barbers    = $this->barber->getByPage($page, $limit, $sort, $filter, $company, $store);
            $pagination = $this->paginator->paginate($this->barber->count(), $limit, $params);
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
            'data'       => $this->barberTransformer->transformCollection($barbers)
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
            $data['store_id']   = empty($data['store']['id'])   ? null : $data['store']['id'];

            $this->validator->validateForCreate($data);

            $barber = $this->barber->create($data);
        }
        catch(ValidationException $e)
        {
            return $this->respondBadRequest($e->getErrors());
        }
        catch(ResourceOnCreateException $e)
        {
            return $this->respondInternalError('There was an error creating the barber.');
        }
        catch(Exception $e)
        {
            return $this->respondInternalError();
        }

        return $this->respondCreated([
            'data' => $this->barberTransformer->transform($barber),
        ],
            [
                'location' => route('api.barbers.show', $barber->id)
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
            $barber = $this->barber->getById($id);
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
            'data' => $this->barberTransformer->transform($barber)
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

            $barber = $this->barber->update($id, $data);
        }
        catch(ValidationException $e)
        {
            return $this->respondBadRequest($e->getErrors());
        }
        catch(Exception $e)
        {
            return $this->respondInternalError('There was an error updating the barber.');
        }

        return $this->respond([
            'data' => $this->barberTransformer->transform($barber),
        ]);
    }

}