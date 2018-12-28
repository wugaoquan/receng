<?php

namespace Liberty\Receng;

use GuzzleHttp\Client;

class User
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client([
            // Base URI is used with relative requests
            'base_uri'        => 'http://receng.test',
            // You can set any number of default request options.
            'timeout'         => 5.0,
            'connect_timeout' => 5.0,
            'http_errors'     => false,
        ]);
    }

    public function lists(array $params)
    {
        $response = $this->client->request('GET', '/api/users', [
            'json' => $params,
        ]);

        $body = (string) $response->getBody();

        $body = json_decode($body, true);

        return $body;
    }
}