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

    /**
     * @throws \ErrorException
     */
    protected function init()
    {
        $this->baseUrl = Kernel()->getConfig('baseUrl');
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