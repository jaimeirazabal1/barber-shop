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
use Barber\Repositories\Customer\CustomerRepository as Customer;
use Barber\Transformers\CustomerTransformer as CustomerTransformer;
use Barber\Services\Paginator\Paginator as Paginator;
use Barber\Validators\Exceptions\ValidationException;
use Exception;
use \Input;
use Barber\Validators\Customer\CustomerValidator as Validator;
use \Carbon\Carbon as Carbon;
use \Barber\Repositories\User\UserRepository as User;


/**
 * Class CustomersController
 * @package Api\V1
 */
class CustomersController extends ApiController {

    /**
     * @var Customer
     */
    private $customer;

    /**
     * @var CustomerTransformer
     */
    private $customerTransformer;

    /**
     * @var Paginator
     */
    private $paginator;

    /**
     * @var Validator
     */
    private $validator;

    protected $user;


    /**
     * @param Customer $customer
     * @param CustomerTransformer $customerTransformer
     * @param Paginator $paginator
     * @param Validator $validator
     */
    public function __construct(Customer $customer, CustomerTransformer $customerTransformer, Paginator $paginator, Validator $validator, User $user)
    {
        $this->customer             = $customer;
        $this->customerTransformer  = $customerTransformer;
        $this->paginator            = $paginator;
        $this->validator            = $validator;
        $this->user                 = $user;
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


        $sortableFieldsAllowed = [
            'first_name',
            'last_name',
            'phone',
            'aka',
            'email'
        ];

        try {
            $sort = build_sortable_fields(Input::get('sort', null), $sortableFieldsAllowed);

            $params = [
                'sort'    => Input::get('sort', null),
                'filter'  => $filter,
                'company' => $company
            ];

            $barbers    = $this->customer->getByPage($page, $limit, $sort, $filter, $company);
            $pagination = $this->paginator->paginate($this->customer->count(), $limit, $params);
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
            'data'       => $this->customerTransformer->transformCollection($barbers)
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
            $data['barber_id']  = empty($data['barber']['id'])  ? null : $data['barber']['id'];
            $data['birthdate']  = ( ! empty($data['birthdate_day']) and ! empty($data['birthdate_month']) and ! empty($data['birthdate_year'])) ? (Carbon::create($data['birthdate_year'], $data['birthdate_month'], $data['birthdate_day'], 0, 0, 0, 'America/Mexico_City')->toDateString()) : null;


            if ( ! empty($data['email']))
            {
                $data['send_email_notifications'] = empty($data['send_email_notifications']) ? false : true;
                $data['create_user_account']      = empty($data['create_user_account']) ? false : true;
            }

            if ( ! empty($data['cellphone']))
            {
                $data['send_cellphone_notifications'] = empty($data['send_cellphone_notifications']) ? false : true;
            }

            $this->validator->validateForCreate($data);

            // TODO : NOTIFICAR AL CLIENTE POR CORREO ELECTRONICO SOBRE SU NUEVA CUENTA
            if ( ! empty($data['create_user_account']))
            {
                $password = \Str::random(12); // Contraseña temporal enviada al cliente
                $password = 'customer';

                $user = $this->user->create([
                    'email' => $data['email'],
                    'password' => $password,
                    'activated' => false,
                    'first_name' => $data['first_name'],
                    'last_name' => $data['last_name']
                ]);
                $data['user_id'] = $user->id;

                // TODO : actualizar a uso de repositorio no modelo directamente
                $company = \Company::find($data['company_id']);

                # Crea el usuario para la empresa
                $company->users()->attach($user->id);
            }

            $customer = $this->customer->create($data);


        }
        catch(ValidationException $e)
        {
            return $this->respondBadRequest($e->getErrors());
        }
        catch(ResourceOnCreateException $e)
        {
            return $this->respondInternalError('There was an error creating the customer.');
        }
        catch(Exception $e)
        {
            return $this->respondInternalError();
        }

        return $this->respondCreated([
            'data' => $this->customerTransformer->transform($customer),
        ],
            [
                'location' => route('api.customers.show', $customer->id)
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
            $customer = $this->customer->getById($id);
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
            'data' => $this->customerTransformer->transform($customer)
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

            $customer = $this->customer->update($id, $data);
        }
        catch(ValidationException $e)
        {
            return $this->respondBadRequest($e->getErrors());
        }
        catch(Exception $e)
        {
            return $this->respondInternalError('There was an error updating the customer.');
        }

        return $this->respond([
            'data' => $this->customerTransformer->transform($customer),
        ]);
    }

}