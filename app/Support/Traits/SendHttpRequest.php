<?php

namespace App\Support\Traits;

use App\Exceptions\RequestExecutionErrorException;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\RequestException;

/**
 * SendHttpRequest trait
 *
 * @category traits
 *
 * @author DmitryKoryagin <kor.dima97@mail.ru>
 */
trait SendHttpRequest
{
    /**
     * @var object
     */
    public object $body;

    /**
     * Execute http request
     *
     * @param string $url
     * @param array $data
     * @return bool|RequestExecutionErrorException
     * @throws RequestException
     */
    public function sendRequest(string $url, array $data) : bool|RequestException
    {
        $response = Http::acceptJson()
            ->get($url, $data)
            ->throw();

        $this->body = $response->object();

        return $response->ok();
    }
}
