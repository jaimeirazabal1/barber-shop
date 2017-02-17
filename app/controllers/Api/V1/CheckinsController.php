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
use Barber\Repositories\Checkin\CheckinRepository as Checkin;
use Barber\Repositories\Barber\BarberRepository as Barber;
use Barber\Transformers\CheckinTransformer as CheckinTransformer;
use Barber\Services\Paginator\Paginator as Paginator;
use Barber\Validators\Exceptions\ValidationException;
use Exception;
use \Input;
use \Carbon\Carbon as Carbon;
use Barber\Validators\Checkin\CheckinValidator as Validator;

/**
 * Class CheckinsController
 * @package Api\V1
 */
class CheckinsController extends ApiController {

    /**
     * @var Checkin
     */
    private $checkin;

    /**
     * @var
     */
    private $barber;

    /**
     * @var CheckinTransformer
     */
    private $checkinTransformer;

    /**
     * @var Paginator
     */
    private $paginator;

    /**
     * @var Validator
     */
    private $validator;


    /**
     * @param Checkin $checkin
     * @param CheckinTransformer $checkinTransformer
     * @param Paginator $paginator
     * @param Validator $validator
     */
    public function __construct(Checkin $checkin, Barber $barber, CheckinTransformer $checkinTransformer, Paginator $paginator, Validator $validator)
    {
        $this->checkin             = $checkin;
        $this->barber              = $barber;
        $this->checkinTransformer  = $checkinTransformer;
        $this->paginator           = $paginator;
        $this->validator           = $validator;
    }


    /**
     *
     */
    public function index()
    {
        $page      = Input::get('page', 1);
        $limit     = Input::get('limit', 10);
        $barber    = Input::get('barber', null);
        $store     = Input::get('store', null);
        $date_from = Input::get('from', null);
        $date_to   = Input::get('to', null);
        $date_to   = empty($date_from) ? null : $date_to;

        // TODO : agregar ?include=barber,store
        $include   = Input::get('include', null);


        $sortableFieldsAllowed = [
            'checkin'
        ];

        try {
            $sort = build_sortable_fields(Input::get('sort', null), $sortableFieldsAllowed);

            $params = [
                'sort'   => Input::get('sort', null),
                'from'   => $date_from,
                'to'     => $date_to,
                'barber' => $barber,
                'store'  => $store
            ];

            $checkins   = $this->checkin->getByPage($page, $limit, $sort, $date_from, $date_to, $barber, $store);
            $pagination = $this->paginator->paginate($this->checkin->count(), $limit, $params);
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
            'data'       => $this->checkinTransformer->transformCollection($checkins)
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
            if ( empty($data['code']))
            {
                throw new ResourceOnCreateException('The barber\'s code can not be empty.');
            }

            $barber = $this->barber->getByCode($data['code']);

            $date = Carbon::now();

            $data['checkin'] = $date->toDateTimeString();

            # Sucursal de la que se registro el checkin
            $data['store_id'] = empty($data['store']['id']) ? null : $data['store']['id'];

            # Barbero que se registro en el checador
            $data['barber_id'] = $barber->id;

            $dayOfWeek = getDayOfWeek($date->dayOfWeek); // MONDAY - SUNDAY

            // TODO : modificar API para obtener los horarios de la sucursal
            $schedule = \Schedule::onDay($dayOfWeek)->byStore($data['store_id'])->first();

            if ( empty($schedule))
            {
                throw new \Exception('No hay un horario especificado para el checador.');
            }

            $store         = \Store::find($data['store_id']);
            $checkin_limit = Carbon::createFromFormat('H:i:s', $schedule->checkin_limit)->addMinutes($store->tolerance_time);

            if($date->gt($checkin_limit))
            {
                $data['status'] = 'retardment';
            }
            else if ($date->lte($checkin_limit))
            {
                $data['status'] = 'present';
            }

            $this->validator->validateForCreate($data);

            // TODO : mover lógica de dominio
            if ((int) $barber->store_id !== (int) $data['store_id'])
            {
                throw new ResourceOnCreateException('The barber can not check in from this store...');
            }

            $checkin = $this->checkin->create($data);
        }
        catch(ValidationException $e)
        {
            return $this->respondBadRequest($e->getErrors());
        }
        catch(ResourceNotFoundException $e)
        {
            return $this->respondNotFound($e->getMessage());
        }
        catch(ResourceOnCreateException $e)
        {
            return $this->respondInternalError('There was an error creating the checkin.');
        }
        catch(Exception $e)
        {
            return $this->respondInternalError();
        }

        return $this->respondCreated([
            'data' => $this->checkinTransformer->transform($checkin),
        ],
            [
                'location' => route('api.checkins.show', $checkin->id)
            ]
        );
    }

    /**
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        // TODO : agregar ?include=barber,store
        try
        {
            $checkin = $this->checkin->getById($id);
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
            'data' => $this->checkinTransformer->transform($checkin)
        ]);
    }

}