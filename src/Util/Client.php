<?php

declare(strict_types=1);

namespace App\Util;

use \GuzzleHttp\Client as GuzzleHttpClient;
use Psr\Http\Message\ResponseInterface;

class Client
{
    /**
     * @return GuzzleHttpClient
     */
    protected function getClient(): GuzzleHttpClient
    {
        return new GuzzleHttpClient();
    }

    /**
     * @param $uri
     * @param array $options
     * @return ResponseInterface
     */
    public function get($uri, array $options = []):ResponseInterface
    {
        return $this->getClient()->get($uri, $options);
    }

}