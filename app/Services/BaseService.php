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
 * @method array sendErrorResponse(array $errorArray, int $code = 422)
 * @method mixed rightCheck(object $object)
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
     * @param array|string $messages array errors messages
     * 
     * @return void
     */
    public function logErrorValidate(array|string $messages) : void
    {
        $messages = (array)$messages;

        foreach ($messages as $message) {
            $this->errors[] = [
                'message' => $message,
            ];
        }
    }

    /**
     * Send errors response
     *
     * @param array   $errorArray array errors messages
     * @param integer $code       number response code
     * 
     * @return array
     */
    protected function sendErrorResponse(array|string $errorArray, int $code = 422) : array
    {
        $this->logErrorValidate($errorArray);
        $this->status = false;
        $this->code = $code;

        return $this->sendResponse();
    }

    /**
     * Send http request
     *
     * @param string $url   http link
     * @param array  $param array param
     * 
     * @throws RequestExecutionErrorException
     * 
     * @return Response
     */
    protected function sendHttpRequest(string $url, array $param) : Response
    {
        $request = Http::acceptJson()
            ->get($url, $param);

        if (!$request->ok()) {
            return throw new RequestExecutionErrorException();
        }

        return $request;
    }

    /**
     * Sms code check
     *
     * @param object $request
     * 
     * @throws ErrorCodeException
     * @return bool
     */
    protected function smsCodeCheck(object $request) : bool|ErrorCodeException
    {
        if ($request->session()->get($request->phone) != $request->code) {
            return throw new ErrorCodeException();
        }

        $request->session()->forget($request->phone);

        return true;
    }

    /**
     * Email code check
     *
     * @param object $request
     * 
     * @throws ErrorCodeException
     * @return bool
     */
    protected function emailCodeCheck(object $request) : bool|ErrorCodeException
    {
        if ($request->session()->get($request->email) != $request->code) {
            return throw new ErrorCodeException();
        }

        $request->session()->forget($request->phone);

        return true;
    }
}