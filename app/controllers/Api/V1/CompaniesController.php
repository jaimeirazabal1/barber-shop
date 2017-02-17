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
use Barber\Repositories\Company\CompanyRepository as Company;
use Barber\Transformers\CompanyTransformer as CompanyTransformer;
use Barber\Services\Paginator\Paginator as Paginator;
use Barber\Validators\Exceptions\ValidationException;
use Exception;
use \Input;
use Barber\Validators\Company\CompanyValidator as Validator;

/**
 * Class CompaniesController
 * @package Api\V1
 */
class CompaniesController extends ApiController {

    /**
     * @var Company
     */
    private $company;

    /**
     * @var CompanyTransformer
     */
    private $companyTransformer;

    /**
     * @var Paginator
     */
    private $paginator;

    /**
     * @var Validator
     */
    private $validator;


    /**
     * @param Company $company
     * @param CompanyTransformer $companyTransformer
     * @param Paginator $paginator
     * @param Validator $validator
     */
    public function __construct(Company $company, CompanyTransformer $companyTransformer, Paginator $paginator, Validator $validator)
    {
        $this->company            = $company;
        $this->companyTransformer = $companyTransformer;
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
        // TODO : agregar ?include=owner,users,etc
        $include = Input::get('include', null);


        $sortableFieldsAllowed = [
            'name',
        ];

        try {
            $sort = build_sortable_fields(Input::get('sort', null), $sortableFieldsAllowed);

            $params = [
                'sort'   => Input::get('sort', null),
                'filter' => $filter,
            ];

            $companies  = $this->company->getByPage($page, $limit, $sort, $filter);
            $pagination = $this->paginator->paginate($this->company->count(), $limit, $params);
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
            'data'       => $this->companyTransformer->transformCollection($companies)
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
            # ID de usuario al cual pertenece la empresa
            $data['user_id'] = empty($data['user']) ? null : $data['user']['id'];

            $this->validator->validateForCreate($data);

            # Slug de la empresa, es único por empresa
            $data['slug']    = \Str::slug($data['name']);

            $company = $this->company->create($data);
        }
        catch(ValidationException $e)
        {
            return $this->respondBadRequest($e->getErrors());
        }
        catch(ResourceOnCreateException $e)
        {
            return $this->respondInternalError('There was an error creating the company.');
        }
        catch(Exception $e)
        {
            return $this->respondInternalError('There was an error creating the company.');
        }

        return $this->respondCreated([
            'data' => $this->companyTransformer->transform($company),
        ],
            [
                'location' => route('api.companies.show', $company->id)
            ]
        );
    }

    /**
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        // TODO : agregar ?include=owner,users,etc
        try
        {
            $company = $this->company->getById($id);
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
            'data' => $this->companyTransformer->transform($company)
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

            # Slug de la empresa, único por empresa
            $data['slug'] = \Str::slug($data['name']);

            $company = $this->company->update($id, $data);
        }
        catch(ValidationException $e)
        {
            return $this->respondBadRequest($e->getErrors());
        }
        catch(Exception $e)
        {
            return $this->respondInternalError('There was an error updating the company.');
        }

        return $this->respond([
            'data' => $this->companyTransformer->transform($company),
        ]);
    }

}