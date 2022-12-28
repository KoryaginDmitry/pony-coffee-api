<?php

namespace App\Service;

class BaseService
{
    protected int $code = 200;
    protected mixed $data = null;
    protected array $errors = [];
    protected bool $status = true;

    public function __construct()
    {
        
    }

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

    protected function getLastErrors()
    {
        return count($this->errors) > 0 ? $this->errors : null;   
    }

    /**
     * @param $messages
     * @param string $type
     */
    public function logErrorValidate ($messages, string $type = 'error'): void
    {
        $messages = (array)$messages;

        foreach ($messages as $message) {
            $this->errors[] = [
                'type' => $type,
                'message' => $message,
            ];
        }
    }

    public function sendErrorResponse(array $errorArray, int $code = 422)
    {
        $this->logErrorValidate($errorArray);
        $this->status = false;
        $this->code = $code;

        return $this->sendResponse();
    }
}