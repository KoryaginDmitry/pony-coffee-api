<?php

/**
 * Base service
 * php version 8.1.2
 * 
 * @category Services
 * 
 * @author DmitryKoryagin <kor.dima97@mail.ru>
 */
namespace App\Services;

use App\Exceptions\ErrorCodeException;
use App\Exceptions\RequestExecutionErrorException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

/**
 * BaseService class
 * 
 * @property int $code code response
 * @property mixed $data data response
 * @property array $errors array errors response
 * @property bool $status status response
 * 
 * @method array sendReponse()
 * @method array|null getLastErrors()
 * @method void logErrorValidate(array|string $messages)
 * @method array sendErrorResponse(array $errorArray, int $resonseCode = 422)
 * @method Response|RequestExecutionErrorException sendHttpRequest()
 * @method bool|ErrorCodeException codeCheck()
 * 
 * @category Services
 * 
 * @author DmitryKoryagin <kor.dima97@mail.ru>
 */
class BaseService
{
    /**
     * Response code
     *
     * @var int
     */
    protected int $code = 200;

    /**
     * Data response
     *
     * @var mixed
     */
    protected mixed $data = null;

    /**
     * Array errors response
     *
     * @var array
     */
    protected array $errors = [];

    /**
     * Status reponse
     *
     * @var boolean
     */
    protected bool $status = true;

    /**
     * Send response
     *
     * @return array
     */
    protected function sendResponse() : array
    {   
        $errors = $this->getLastErrors();

        $this->errors = [];
        
        return [
            "status" => $this->status,
            "data" => $this->data,
            "errors" => $errors,
            "code" => $this->code
        ];
    }

    /**
     * Get last errors
     *
     * @return array|null
     */
    protected function getLastErrors() : array|null
    {
        return count($this->errors) > 0 ? $this->errors : null;   
    }

    /**
     * Fill errors param
     *
     * @param array|string $messages array or string errors messages
     * 
     * @return void
     */
    public function logErrorValidate(array|string $messages) : void
    {
        $messages = (array)$messages;

        foreach ($messages as $message) {
            $this->errors['messages'][] = [
                $message,
            ];
        }
    }

    /**
     * Send errors response
     *
     * @param array   $errorArray
     * @param integer $responseCode       
     * 
     * @return array
     */
    protected function sendErrorResponse(array|string $errorArray, int $responseCode = 422) : array
    {
        $this->logErrorValidate($errorArray);
        $this->status = false;
        $this->code = $responseCode;

        return $this->sendResponse();
    }

    /**
     * make http request
     *
     * @param string $url
     * @param array  $param
     * 
     * @throws RequestExecutionErrorException
     * 
     * @return Response
     */
    protected function sendHttpRequest(string $url, array $param) : Response|RequestExecutionErrorException
    {
        $request = Http::acceptJson()
            ->get($url, $param);

        if (!$request->ok()) {
            return throw new RequestExecutionErrorException();
        }

        return $request;
    }

    /**
     * Checks the code
     *
     * @param string $value phone or email
     * @param int    $code
     * 
     * @throws ErrorCodeException
     * @return bool
     */
    protected function codeCheck(string $value, int $code) : bool|ErrorCodeException
    {
        if (session($value) != $code) {
            return throw new ErrorCodeException();
        }

        session()->forget($value);

        return true;
    }
}