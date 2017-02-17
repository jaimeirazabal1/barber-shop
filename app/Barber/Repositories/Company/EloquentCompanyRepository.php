<?php namespace Barber\Repositories\Company;
/**
 * Created by Apptitud.mx.
 * Company: diegogonzalez
 * Date: 7/30/15
 * Time: 12:11 PM
 */

use Barber\Repositories\Exceptions\ResourceOnCreateException;
use Barber\Repositories\Exceptions\ResourceNotFoundException;
use Exception;
use \Barber\Repositories\CountableInterface;
use \Barber\Repositories\SortableInterface;
use \Barber\Repositories\FilterableInterface;
use \DB;
use \Company;

/**
 * Class EloquentCompanyRepository
 * @package Barber\Repositories\Company
 */
class EloquentCompanyRepository implements CompanyRepository, CountableInterface, SortableInterface, FilterableInterface {

    /**
     * @var Company
     */
    protected $company;

    /**
     * @var
     */
    protected $query;

    /**
     * @var
     */
    protected $count;

    /**
     * @param Company $company
     */
    public function __construct(Company $company)
    {
        $this->company = $company;
    }

    /**
     * @param $company_id
     * @return mixed
     * @throws \Barber\Repositories\Exceptions\ResourceNotFoundException
     */
    public function getById($company_id)
    {
        if ( ! $company = $this->company->find($company_id))
        {
            throw new ResourceNotFoundException("The company with the ID: {$company_id} does not exists.");
        }

        return $company;
    }

    /**
     * @param $company_slug
     * @return mixed
     * @throws ResourceNotFoundException
     */
    public function getBySlug($company_slug)
    {
        $company = $this->company->bySlug($company_slug)->first();
        
        if (!isset($company->name))
        {
            throw new ResourceNotFoundException("The company with the slug: {$company_slug} does not exists.");
        }

        return $company;
    }


    /**
     * Crea una empresa
     *
     * @param array $data
     * @return mixed|void
     * @throws ResourceOnCreateException
     */
    public function create(array $data)
    {
        DB::beginTransaction();

        try
        {
            $company = $this->company->create($data);
        }
        catch(Exception $e)
        {
            DB::rollback();
            throw new ResourceOnCreateException('There was an error while creating the company.');
        }

        DB::commit();

        return $company;
    }

    /**
     * Actualiza la información de la empresa
     *
     * @param $company_id
     * @param array $data
     * @return mixed|void
     * @throws Exception
     */
    public function update($company_id, array $data)
    {
        $company = $this->getById($company_id);

        $company->name    = empty($data['name']) ? $company->email : $data['name'];
        $company->user_id = empty($data['user_id']) ? $company->user_id : $data['user_id'];
        $company->slug    = empty($data['slug']) ? $company->slug : $data['slug'];

        $company->save();

        return $company;
    }

    /**
     * Obtiene todos los Usuarios
     *
     * @param int $page
     * @param int $limit
     * @param array $sort
     * @param array $filter
     * @return mixed|void
     */
    public function getByPage($page = 1, $limit = 10, array $sort = array(), $filter = null)
    {
        $this->query = $this->company;

        # Aplica el filtro de búsqueda
        if ( ! empty($filter))
        {
            $this->query = $this->filter($filter);
        }

        # Cuenta los registros de la consulta
        $this->count = $this->query->count();

        # Toma los registros seleccionados
        $this->query = $this->query->skip($limit * ($page - 1))->take($limit);

        # Aplica el ordenamiento de columnas
        if ( ! empty($sort))
        {
            $this->query = $this->sort($sort);
        }

        # Obtiene los registros
        #$this->query = $this->query->with('owner')->get();
        $this->query = $this->query->get();


        # Retorna los registros en forma de arreglo de objetos
        return $this->query->all();
    }

    /**
     * Obtiene el número de registros totales
     *
     * @return mixed
     */
    public function count()
    {
        return $this->count;
    }


    /**
     * Crea el ordenamiento de los campos
     *
     * @param array $fields
     * @return mixed
     */
    public function sort(array $fields)
    {
        foreach($fields as $field)
        {
            $this->query = $this->query->orderBy($field['field'], $field['order']);
        }

        return $this->query;
    }

    /**
     * Aplica filtro deseado en la consulta
     *
     * @param $filter
     * @return mixed
     */
    public function filter($filter)
    {
        $this->query = $this->company->filter($filter);

        return $this->query;
    }

}