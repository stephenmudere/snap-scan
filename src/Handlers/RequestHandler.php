<?php namespace Stephenmudere\SnapScan\Handlers;

use GuzzleHttp\Client;
use PhpParser\Node\Expr\Cast\Object_;

class RequestHandler
{
    protected $guzzleClient;

    public function __construct()
    {
        $this->guzzleClient = new Client(['base_uri' => config('snap_scan.api_base_url')]);
    }

    public function doRequest($method, $url, array $data = [], $json = true)
    {
        $options['auth'] = [config('snap_scan.api_key'), NULL];
        $options['query'] = $data;

        try
        {
            return $this->buildResponse(
                $this->guzzleClient->request($method,$url,$options),
                $json
            );
        }
        catch (\Exception $ex)
        {
            return $this->buildResponse(
                $this->guzzleClient->request($method,$url,$options),   // guzzle response
                $json,                                              // json ret
                $ex->getMessage(),                                  // exception message
                true                                                // error true
            );
        }
    }

    private function buildResponse($response, $json, $message = [], $error = false)
    {
        $responseArray = [];

        $responseArray['message'] = $message;
        $responseArray['error'] = $error;

        $responseArray['response_header'] = $response->getHeader('content-type'); // JSON
        $responseArray['response_code'] = $response->getStatusCode();
        $responseArray['response_body'] = $response->getBody()->getContents();

        if($json)
            return json_encode($responseArray);

        return (object) $responseArray;
    }
}