<?php

/**
 * Base service
 * php version 8.1.2
 * 
 * @category Services
 * 
 * @package Category
 * 
 * @author DmitryKoryagin <kor.dima97@maiol.ru>
 * 
 * @license http://href.com MIT
 * 
 * @link http://href.com
 */
namespace App\Service;

/**
 * BaseService class
 * 
 * @method array sendReponse()
 * @method array getLastErrors()
 * @method array logErrorValidate()
 * @method array sendErrorResponse()
 * 
 * @category Services
 * 
 * @package Category
 * 
 * @author DmitryKoryagin <kor.dima97@email.ru>
 * 
 * @license http://href.com MIT
 * 
 * @link http://href.com
 */
class BaseService
{
    /**
     * Response code
     *
     * @var integer
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
     * Get lust errors
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
    public function sendErrorResponse(array $errorArray, int $code = 422) : array
    {
        $this->logErrorValidate($errorArray);
        $this->status = false;
        $this->code = $code;

        return $this->sendResponse();
    }
}