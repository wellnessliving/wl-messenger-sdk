<?php

declare(strict_types=1);

namespace WellnessLiving\MessengerSdk;

use Illuminate\Support\Facades\Facade;

class MessengerSdkFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'messengerSdk';
    }
}
