<?php

namespace App;

use Psr\Http\Client\ClientInterface;

class ImageClient
{
    protected ClientInterface $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    public function fetchRandom(): array
    {
        return $this->request('GET', 'http://api/images/random')['data'];
    }

    protected function request(string $method, string $uri = '', array $options = [])
    {
        $response = $this->client->request($method, $uri, $options);

        $json = $response->getBody()->getContents();

        return json_decode($json, true);
    }
}
