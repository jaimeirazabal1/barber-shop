<?php namespace Barber\Services\Paginator;
/**
 * Created by Apptitud.mx.
 * User: diegogonzalez
 * Date: 7/31/15
 * Time: 11:35 AM
 */

use \Paginator as Pag;
use \Request as Request;

/**
 * Class LaravelPaginator
 * @package Barber\Services\Paginator
 */
class LaravelPaginator implements Paginator {

    /**
     * @var
     */
    protected $paginator;

    /**
     * @var
     */
    protected $url;

    /**
     * @var
     */
    protected $limit;

    /**
     * @var
     */
    protected $total;

    /**
     * @var
     */
    protected $params = array();

    /**
     * Devuelve los datos paginados
     *
     * @param $totalItems
     * @param $limit
     * @param array $params
     * @return mixed
     */
    public function paginate($totalItems, $limit, array $params = array())
    {
        $this->paginator = Pag::make(array(), $totalItems, $limit);


        $this->url       = Request::url();
        $this->limit     = $limit;
        $this->params    = $params;

        $pagination = [
            'links' => [
                'self'  => $this->getSelfPage(),
                'first' => $this->getFirstPage(),
                'prev'  => $this->getPrevPage(),
                'next'  => $this->getNextPage(),
                'last'  => $this->getLastPage()
            ],
            'meta' => [
                'total' => $this->paginator->getTotal(),
                'perPage' => $this->paginator->getPerPage(),
                'currentPage' => $this->paginator->getCurrentPage(),
                'lastPage' => $this->paginator->getLastPage(),
                'from' => $this->paginator->getFrom(),
                'to' => $this->paginator->getTo(),

            ]
        ];

        return $pagination;
    }

    /**
     * @return null
     */
    public function getNextPage()
    {
        $nextPage = $this->paginator->getCurrentPage() + 1;

        #dd($nextPage);

        if ( $nextPage >= $this->paginator->getLastPage())
        {
            return null;
        }

        return $this->getPage($nextPage);
    }

    /**
     * @return null
     */
    public function getPrevPage()
    {
        $prevPage = $this->paginator->getCurrentPage() - 1;

        if ( $prevPage == 0)
        {
            return null;
        }

        return $this->getPage($prevPage);
    }

    /**
     *
     */
    public function getSelfPage()
    {
        return $this->getPage($this->paginator->getCurrentPage());
    }

    /**
     *
     */
    public function getFirstPage()
    {
        return $this->getPage(1);
    }

    /**
     *
     */
    public function getLastPage()
    {
        return $this->getPage($this->paginator->getLastPage());
    }

    /**
     * @param int $page
     * @return string
     */
    protected function getPage($page = 1)
    {
        return $this->paginator->getUrl($page) . $this->getParams();
    }


    /**
     *
     */
    protected function getParams()
    {
        $params       = array();
        $query_string = '&';

        $params_pagination = [
            'limit' => $this->limit
        ];

        $this->params = array_merge($params_pagination, $this->params);

        foreach($this->params as $param => $value)
        {
            if ( ! empty($value))
            {
                $params[] = ($param . '=' . $value);
            }

        }

        $query_string .= implode('&', $params);

        return $query_string;
    }


}