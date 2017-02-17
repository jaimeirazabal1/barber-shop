<?php namespace Api;
/**
 * Created by Apptitud.mx.
 * User: diegogonzalez
 * Date: 7/30/15
 * Time: 10:42 AM
 */

use \Response;

/**
 * Class ApiController
 * @package Api
 */
class ApiController extends \BaseController {

    /**
     * Status por default
     *
     * @var int
     */
    protected $statusCode = 200;

    /**
     * @return string
     */
    public function notindex()
    {
        return 'api';
    }


    /**
     * Obtiene el código de estado
     *
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }


    /**
     * Establece el código de estado
     *
     * @param $statusCode
     * @return $this
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }



    /**
     * Devuelve la respuesta
     *
     * @param $data
     * @param array $headers
     * @return mixed
     */
    public function respond($data, $headers = array())
    {
        return Response::json($data, $this->getStatusCode(), $headers);
    }


    /**
     * Crea un recurso en el servidor
     *
     * @param $data
     * @param array $headers
     * @return mixed
     */
    public function respondCreated($data, $headers = array())
    {
        return $this->setStatusCode(201)->respond($data, $headers);
    }


    /**
     * Devuelve la respuesta con error
     *
     * @param $message
     * @return mixed
     */
    public function respondWithError($message)
    {
        return $this->respond(array(
            'error' => array(
                'message' => $message,
                'status_code' => $this->getStatusCode()
            )
        ));
    }



    /**
     * Devuelve la respuesta de recurso no encontrado
     *
     * @param string $message
     * @return mixed
     */
    public function respondNotFound($message = 'Not Found!')
    {
        return $this->setStatusCode(404)->respondWithError($message);
    }


    /**
     * Devuelve la respuesta con error del servidor
     *
     * @param string $message
     * @return mixed
     */
    public function respondInternalError($message = 'Internal Error!')
    {
        return $this->setStatusCode(500)->respondWithError($message);
    }


    /**
     * Devuelve la respuesta  con error de no autorizado
     *
     * @param string $message
     * @return mixed
     */
    public function respondNotAuthorized($message = 'Not authorized!')
    {
        return $this->setStatusCode(401)->respondWithError($message);
    }


    /**
     * Devuelve la respuesta con error de petición mal formada
     *
     * @param string $message
     * @return mixed
     */
    public function respondBadRequest($message = 'Bad Request!')
    {
        return $this->setStatusCode(400)->respondWithError($message);
    }


    /**
     * Devuelve la respuesta con error de acceso no autorizado
     *
     * @param string $message
     * @return mixed
     */
    public function respondForbidden($message = 'Forbidden!')
    {
        return $this->setStatusCode(403)->respondWithError($message);
    }


    /**
     * Devuelve la respuesta con error de acceso no autorizado
     *
     * @param string $message
     * @return mixed
     */
    public function respondPaymentRequired($message = 'Payment required!')
    {
        return $this->setStatusCode(402)->respondWithError($message);
    }


}