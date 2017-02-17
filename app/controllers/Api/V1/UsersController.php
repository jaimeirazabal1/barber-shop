<?php namespace Api\V1;
/**
 * Created by Apptitud.mx.
 * User: diegogonzalez
 * Date: 7/30/15
 * Time: 11:06 AM
 */

use \Api\ApiController;
use Barber\Repositories\Exceptions\ResourceNotFoundException;
use Barber\Repositories\Exceptions\Sort\SortableFieldInvalid;
use Barber\Repositories\Exceptions\Sort\SortableFieldNotAllowed;
use \Barber\Repositories\User\UserRepository as User;
use \Barber\Transformers\UserTransformer as UserTransformer;
use \Barber\Services\Paginator\Paginator as Paginator;
use Barber\Validators\Exceptions\ValidationException;
use Exception;
use \Input;
use Barber\Validators\User\UserValidator as Validator;

/**
 * Class UsersController
 * @package Api\V1
 */
class UsersController extends ApiController {

    /**
     * @var
     */
    private $user;

    /**
     * @var UserTransformer
     */
    private $userTransformer;

    /**
     * @var Paginator
     */
    private $paginator;

    /**
     * @var Validator
     */
    private $validator;


    /**
     * @param User $user
     * @param UserTransformer $userTransformer
     * @param Paginator $paginator
     */
    public function __construct(User $user, UserTransformer $userTransformer, Paginator $paginator, Validator $validator)
    {
        $this->user            = $user;
        $this->userTransformer = $userTransformer;
        $this->paginator       = $paginator;
        $this->validator       = $validator;
    }


    /**
     *
     */
    public function index()
    {
        $page    = Input::get('page', 1);
        $limit   = Input::get('limit', 10);
        $filter  = Input::get('filter', null);

        $sortableFieldsAllowed = [
            'email',
            'first_name',
            'last_name'
        ];

        try {
            $sort = build_sortable_fields(Input::get('sort', null), $sortableFieldsAllowed);

            $params = [
                'sort'   => Input::get('sort', null),
                'filter' => $filter,
            ];

            $users      = $this->user->getByPage($page, $limit, $sort, $filter);
            $pagination = $this->paginator->paginate($this->user->count(), $limit, $params);
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
            'data'       => $this->userTransformer->transformCollection($users)
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
            $this->validator->validateForCreate($data);

            $user = $this->user->create($data);
        }
        catch(ValidationException $e)
        {
            return $this->respondBadRequest($e->getErrors());
        }
        catch(Exception $e)
        {
            return $this->respondInternalError('There was an error creating the user.');
        }

        return $this->respondCreated([
                /*'data' => [
                    'type' => 'users',
                    'id'   => $user->id,
                    'attributes' => $this->userTransformer->transform($user),
                ],
                'links' => [
                    'self' => route('api.users.show', $user->id)
                ],*/
                'data' => $this->userTransformer->transform($user),
            ],
            [
                'location' => route('api.users.show', $user->id)
            ]
        );
    }

    /**
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        try
        {
            $user = $this->user->getById($id);
        }
        catch(ResourceNotFoundException $e)
        {
            return $this->respondNotFound($e->getMessage());
        }

        return $this->respond([
            'data' => $this->userTransformer->transform($user)
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

            $user = $this->user->update($id, $data);
        }
        catch(ValidationException $e)
        {
            return $this->respondBadRequest($e->getErrors());
        }
        catch(Exception $e)
        {
            return $this->respondInternalError('There was an error updating the user.');
        }

        return $this->respond([
            'data' => $this->userTransformer->transform($user),
        ]);
    }

}