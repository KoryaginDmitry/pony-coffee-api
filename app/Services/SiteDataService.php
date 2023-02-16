<?php

namespace App\Services;

use App\Models\Bonus;
use App\Models\User;
use App\Support\Traits\DataPrepareTrait;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

/**
 * SiteDataService class
 *
 * @category Services
 *
 * @author DmitryKoryagin <kor.dima97@mail.ru>
 */
class SiteDataService extends BaseService
{
    use DataPrepareTrait;

    /**
     * Get header for role user
     *
     * @return array
     */
    public function header() : array
    {
        $this->data = [
            'header' => config("options.header." . User::staticGetRole())
        ];

        return $this->sendResponse();
    }

    /**
     * Get bonus lifetime
     *
     * @return array
     */
    public function bonusLifetime() : array
    {
        $this->data = [
            'lifetime' => Bonus::getLifetime()
        ];

        return $this->sendResponse();
    }

    public function getChannels()
    {
        $this->data = [
            'channels' => Arr::map(
                config("options.channels." . User::staticGetRole()),
                function (array $value) {
                    $value['path'] = Str::replace('{id}', auth()->id(), $value['path']);
                    return $value;
                }
            )
        ];

        return $this->sendResponse();
    }
}
