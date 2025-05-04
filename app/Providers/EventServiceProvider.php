<?php

namespace App\Providers;

use App\Events\ClearRedisEvent;
use App\Events\NewCarUpdated;
use App\Listeners\ClearRedis;
use App\Events\SocialVideoUpdated;
use App\Listeners\ClearRedisNewCarListener;
use App\Listeners\ClearRedisSocialVideoListener;
use App\Model\NewCar;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        NewCarUpdated::class => [
            ClearRedisNewCarListener::class
        ],
        ClearRedisEvent::class => [
            ClearRedis::class
        ],
        SocialVideoUpdated::class => [
            ClearRedisSocialVideoListener::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
