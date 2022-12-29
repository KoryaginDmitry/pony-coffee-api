<?php

namespace App\Service;

class BaseService
{
    protected int $code = 200;
    protected mixed $data = null;
    protected array $errors = [];
    protected bool $status = true;

    /**
     * Undocumented function
     *
     * @return void
     */
    protected function sendResponse()
    {   
        $errors = $this->getLastErrors();

        $this->errros = [];
        
        return [
            "status" => $this->status,
            "data" => $this->data,
            "errors" => $errors,
            "code" => $this->code
        ];
    }

    /**
     * Method return array errors
     *
     * @return array
     */
    protected function getLastErrors() :array
    {
        return count($this->errors) > 0 ? $this->errors : null;   
    }

    /**
     * Fill errors param
     *
     * @param mixed  $messages comment sad
     * @param string $type     comment sd
     * 
     * @return void
     */
    public function logErrorValidate(array|string $messages, string $type = 'error'): void
    {
        $messages = (array)$messages;

        foreach ($messages as $message) {
            $this->errors[] = [
                'type' => $type,
                'message' => $message,
            ];
        }
    }

    /**
     * Undocumented function
     *
     * @param array   $errorArray comment da
     * @param integer $code       commetn sad
     * 
     * @return void
     */
    public function sendErrorResponse(array $errorArray, int $code = 422)
    {
        $this->logErrorValidate($errorArray);
        $this->status = false;
        $this->code = $code;

        return $this->sendResponse();
    }
}