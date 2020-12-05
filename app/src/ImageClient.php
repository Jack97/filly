<?php

namespace App;

use App\Entity\Image;
use Psr\Http\Client\ClientInterface;

class ImageClient
{
    protected ClientInterface $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    public function fetchRandom(): Image
    {
        // Todo: Make api endpoint configurable

        $response = $this->request('GET', '/images/random');

        return new Image($response['data']);
    }

    protected function request(string $method, string $uri = '', array $options = [])
    {
        $response = $this->client->request($method, $uri, $options);

        $json = $response->getBody()->getContents();

        return json_decode($json, true);
    }
}
