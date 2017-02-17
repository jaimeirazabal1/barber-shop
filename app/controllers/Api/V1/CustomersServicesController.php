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
use Barber\Repositories\Customer\Service\ServiceRepository as Service;
use Barber\Transformers\CustomerServiceTransformer as ServiceTransformer;
use Barber\Services\Paginator\Paginator as Paginator;
use Barber\Validators\Exceptions\ValidationException;
use Exception;
use \Input;
use Barber\Validators\Customer\Service\ServiceValidator as Validator;
use \InvalidArgumentException;

/**
 * Class ServicesServicesController
 * @package Api\V1
 */
class CustomersServicesController extends ApiController {

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
        $this->service             = $service;
        $this->serviceTransformer  = $serviceTransformer;
        $this->paginator           = $paginator;
        $this->validator           = $validator;
    }


    /**
     *
     */
    public function index($customer_id)
    {
        try
        {
            $services   = $this->service->getAll($customer_id);
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
            'data'       => $this->serviceTransformer->transformCollection($services)
        ]);
    }

    /**
     * @param $customer_id
     * @return mixed
     */
    public function store($customer_id)
    {
        $data = getApiInput();

        // TODO : validar que el servicio no se repita al momento de crear

        try
        {
            $data['service_id'] = empty($data['service']['id']) ? null : $data['service']['id'];

            $this->validator->validateForcreate($data);

            $service = $this->service->create($customer_id, $data);
        }
        catch(ValidationException $e)
        {
            return $this->respondBadRequest($e->getErrors());
        }
        catch(ResourceOnCreateException $e)
        {
            return $this->respondInternalError('There was an error creating the service.' . $e->getMessage());
        }
        catch(Exception $e)
        {
            return $this->respondInternalError();
        }

        return $this->respondCreated([
            'data' => $this->serviceTransformer->transform($service),
        ],
            [
                'location' => route('api.customers.services.show', [$customer_id, $service->id])
            ]
        );
    }

    /**
     * @param $id
     * @return mixed
     */
    public function show($customer_id, $id)
    {
        // TODO : agregar ?include=company,etc
        try
        {
            $service = $this->service->getById($customer_id, $id);
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
     * @param $customer_id
     * @param $id
     * @return mixed
     */
    public function update($customer_id, $id)
    {
        $data = getApiInput();

        try
        {
            $this->validator->validateForUpdate($id, $data);

            $service = $this->service->update($customer_id, $id, $data);
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

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($customer_id, $id)
    {
        try
        {
            $service = $this->service->destroy($customer_id, $id);
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