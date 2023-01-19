<?php

/**
 * Base service
 * php version 8.1.2
 * 
 * @category Services
 * 
 * @author DmitryKoryagin <kor.dima97@maiol.ru>
 */
namespace App\Services;

use App\Exceptions\ValidateException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;
use Illuminate\Validation\ValidationException;

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
 * @method ValidateException validate(array $params, array $rules)
 * 
 * @category Services
 * 
 * @author DmitryKoryagin <kor.dima97@email.ru>
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
     * Validate method
     *
     * @param array $params array of parameters for validation
     * @param array $rules  array of validation rules
     * 
     * @throws ValidationException
     * 
     * @return boolean
     */
    protected function validate(array $params, array $rules) : bool|MessageBag
    {
        $validator = Validator::make($params, $rules);

        if ($validator->fails()) {
            return throw new ValidationException($validator);
        }

        return true;
    }
}