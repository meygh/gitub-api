<?php
/**
 * Created by PhpStorm.
 * User: meysam.ghanbari
 * Date: 8/19/22
 * Time: 1:12 PM
 */

namespace Meygh\GithubApi\Base;


use Curl\Curl;

class Api extends Component
{
    /** @var Curl */
    protected $request;

    /** @var array of curl headers parameters */
    protected $headers;

    /** @var string  */
    protected $baseUrl = '';

    /** @var array */
    protected static $errors = [];

    /**
     * @throws \ErrorException
     */
    public function init()
    {
        $this->baseUrl = Console()->getConfig('baseUrl');
        $this->request = new Curl($this->baseUrl);
    }

    /**
     * Add header config for curl request.
     * @param string|array $parameter
     * @param string $value
     * @return $this
     */
    public function header($parameter, string $value = '')
    {
        if (is_array($parameter)) {
            foreach ($parameter as $key => $value) {
                $this->header($key, $value);
            }

            return $this;
        }

        $this->request->setHeader($parameter, $value);

        $this->headers[$parameter] = $value;

        return $this;
    }

    /**
     * Adds an error message into $errors property
     * @param string $error
     */
    public function addErrorMessage(string $error)
    {
        self::$errors['message'] = $error;
    }

    /**
     * Adds and string error with a specific key into $errors property
     * @param string $key
     * @param string $error
     */
    public function addError(string $key, string $error)
    {
        self::$errors[$key] = $error;
    }

    /**
     * Adds array of some details of error as index of 'errors'.
     * @param $error
     */
    public function addErrorInfo($error)
    {
        if ($field = array_get($error, 'field')) {
            self::$errors['errors'][] = $error['message'];
        } else {
            self::$errors['errors'][] = $error;
        }
    }

    /**
     * Returns all defined errors as an array
     * this array may contains 'message' and 'errors' indexes.
     * @return array
     */
    public function getErrors()
    {
        return self::$errors;
    }

    /**
     * @param string $url
     * @param array $data
     * @return mixed
     */
    public function get(string $url, array $data = [])
    {
        return $this->request->get($url, $data);
    }

    /**
     * @param string $url
     * @param array $data
     * @param bool $redirection
     * @return mixed
     */
    public function post(string $url, array $data = [], bool $redirection = false)
    {
        return $this->request->post($url, $data, $redirection);
    }
}