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
use Barber\Repositories\Service\ServiceRepository as Service;
use Barber\Transformers\ServiceTransformer as ServiceTransformer;
use Barber\Services\Paginator\Paginator as Paginator;
use Barber\Validators\Exceptions\ValidationException;
use Exception;
use \Input;
use Barber\Validators\Service\ServiceValidator as Validator;

/**
 * Class ServicesController
 * @package Api\V1
 */
class ServicesController extends ApiController {

    /**
     * @var Service
     */
    private $service;

    /**
     * @var ServiceTransformer
     */
    private $serviceTransformer;

    /**
     * @var Paginator
     */
    private $paginator;

    /**
     * @var Validator
     */
    private $validator;


    /**
     * @param Service $service
     * @param ServiceTransformer $serviceTransformer
     * @param Paginator $paginator
     * @param Validator $validator
     */
    public function __construct(Service $service, ServiceTransformer $serviceTransformer, Paginator $paginator, Validator $validator)
    {
        $this->service            = $service;
        $this->serviceTransformer = $serviceTransformer;
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
        // TODO : agregar ?include=categories
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

            $services    = $this->service->getByPage($page, $limit, $sort, $filter, $company);
            $pagination = $this->paginator->paginate($this->service->count(), $limit, $params);
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
            'data'       => $this->serviceTransformer->transformCollection($services)
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

            $service = $this->service->create($data);
        }
        catch(ValidationException $e)
        {
            return $this->respondBadRequest($e->getErrors());
        }
        catch(ResourceOnCreateException $e)
        {
            return $this->respondInternalError('There was an error creating the service.');
        }
        catch(Exception $e)
        {
            return $this->respondInternalError();
        }

        return $this->respondCreated([
            'data' => $this->serviceTransformer->transform($service),
        ],
            [
                'location' => route('api.services.show', $service->id)
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
            $service = $this->service->getById($id);
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
            'data' => $this->serviceTransformer->transform($service)
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

            $service = $this->service->update($id, $data);
        }
        catch(ValidationException $e)
        {
            return $this->respondBadRequest($e->getErrors());
        }
        catch(Exception $e)
        {
            return $this->respondInternalError('There was an error updating the service.');
        }

        return $this->respond([
            'data' => $this->serviceTransformer->transform($service),
        ]);
    }

}