<?php

namespace Tiger\Receng;

use GuzzleHttp\Client;

class User
{
    protected $client;
    protected $sign;

    public function __construct($base_uri, $token)
    {
        $this->client = new Client([
            // Base URI is used with relative requests
            'base_uri'        => $base_uri,
            // You can set any number of default request options.
            'timeout'         => 5.0,
            'connect_timeout' => 5.0,
            'http_errors'     => false,
        ]);

        //生成签名
        $this->sign = $this->generateSign($token);
    }

    public function lists(array $params)
    {
        $query = $this->sign;

        $response = $this->client->request('GET', '/api/users', [
            'query' => $query,
            'json'  => $params,
        ]);

        $body = (string) $response->getBody();

        $body = json_decode($body, true);

        return $body;
    }

    private function generateSign($token)
    {
        //获取参数
        $timestamp = time();
        $nonce     = mt_rand();

        //运算
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode($tmpArr);
        $tmpStr = sha1($tmpStr);

        //返回
        return array('sign' => $tmpStr, 'timestamp' => $timestamp, 'nonce' => $nonce);
    }
}
