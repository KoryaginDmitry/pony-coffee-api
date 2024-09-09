<?php

namespace App\Actions;

use Exception;
use Illuminate\Support\Facades\Log;
use Longman\TelegramBot\Request;
use Longman\TelegramBot\Telegram;

class SendExceptionToTelegramAction
{
    /**
     * Массив для фильтрации $_SERVER
     */
    protected array $filter_keys = [
        'HTTP_USER_AGENT',
        'HTTP_REFERER',
        'REMOTE_ADDR',
        'REDIRECT_URL',
        'REQUEST_METHOD',
        'QUERY_STRING',
    ];

    public function __construct(
        protected Exception $exception
    ) {}

    public function send(): void
    {
        try {
            new Telegram($this->getBotApiKey(), $this->getBotUserName());

            $result = Request::sendMessage($this->makeMessage());
            if (! $result->isOk()) {
                Log::error('Ошибка отправки исключения', [
                    'description' => $result->getDescription(),
                ]);
            }
        } catch (Exception $e) {
            Log::error('Исключение при отправке сообщения', [
                'message' => $e->getMessage(),
            ]);
        }
    }

    protected function getBotApiKey(): string
    {
        return config('services.telegram-exception-bot.token');
    }

    protected function getBotUserName(): string
    {
        return config('services.telegram-exception-bot.username');
    }

    protected function getChatId(): string
    {
        return config('services.telegram-exception-bot.chat_id');
    }

    protected function makeMessage(): array
    {
        return [
            'chat_id' => $this->getChatId(),
            'text' => 'message - '.$this->exception->getMessage()."\n"
                .'code - '.$this->exception->getCode()."\n"
                .'file - '.$this->exception->getFile()."\n"
                .'line - '.$this->exception->getLine()."\n"
                .'extra - '.implode(',', $this->getExtra())."\n"
                .'date - '.now()->format('d.m.Y H:i:s'),
        ];
    }

    protected function getExtra(): array
    {
        $data = $_SERVER;

        if (is_array($data)) {
            foreach ($data as $s_key => $s_value) {
                if (! in_array($s_key, $this->filter_keys, true)) {
                    unset($data[$s_key]);
                }
            }
        }

        return $data;
    }
}
