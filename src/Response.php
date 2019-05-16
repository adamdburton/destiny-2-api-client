<?php

namespace AdamDBurton\Destiny2ApiClient;

use Psr\Http\Message\ResponseInterface;
use stdClass;

class Response
{
    /**
     * @var ResponseInterface $response
     */
    private $response;

    /**
     * @var stdClass $json
     */
    private $json;

    /**
     * Response constructor.
     * @param ResponseInterface $response
     */
    public function __construct(ResponseInterface $response)
    {
        $this->response = $response;
        $this->json = json_decode((string)$response->getBody());

        if (isset($this->json->Response)) {
            $this->json = $this->json->Response;
        }
    }

    /**
     * @return bool
     */
    public function successful()
    {
        return substr($this->getResponse()->getStatusCode(), 0, 1) == '2';
    }

    /**
     * @return stdClass|stdClass[]
     */
    public function json()
    {
        return $this->json;
    }

    /**
     * @return ResponseInterface
     */
    public function response()
    {
        return $this->response;
    }

    /**
     * @return int
     */
    public function statusCode()
    {
        return $this->response->getStatusCode();
    }

    /**
     * @return string[][]
     */
    public function headers()
    {
        return $this->response->getHeaders();
    }


    public function replaceHashesWithDefinitions()
    {

    }
}