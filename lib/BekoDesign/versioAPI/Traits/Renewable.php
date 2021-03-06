<?php

namespace BekoDesign\versioAPI\Traits;

use BekoDesign\versioAPI\Contracts\IClient;
use GuzzleHttp\Psr7\Request;
use Http\Promise\Promise;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

trait Renewable
{
    /**
     * @var IClient
     */
    protected $client;

    public function renew($id, $data = [], $urlPostfix = ''): ResponseInterface
    {
        return $this->client
            ->sendRequest(
                $this->renewRequest($id, $data, $urlPostfix)
            );
    }

    public function renewAsync($id, $data = [], $urlPostfix = ''): Promise
    {
        return $this->client
            ->sendRequestAsync(
                $this->renewRequest($id, $data, $urlPostfix)
            );
    }

    /**
     * @apram int $id
     * @param array $data
     * @param string $urlPostfix
     * @return RequestInterface
     */
    public function renewRequest($id, $data = [], $urlPostfix = '') : RequestInterface
    {
        $request = new Request('POST', $this->getRenewUrl($id, $data, $urlPostfix));
        $request = $request->withBody(\GuzzleHttp\Psr7\stream_for(\GuzzleHttp\json_encode($data)));

        return $request;
    }

    public function getRenewUrl($key, $data = [], $urlPostfix = '') : string {
        return $this->endpoint . '/' . $key . '/renew' . $urlPostfix;
    }

}