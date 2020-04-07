<?php

namespace App\Providers;

use App\Events\NouvelleRecette;
use App\Events\NouvelleVisite;
use App\Listeners\NouvelleRecetteListener;
use App\Listeners\NouvelleVisiteListener;
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
        NouvelleRecette::class => [
            NouvelleRecetteListener::class
        ],
        NouvelleVisite::class => [
            NouvelleVisiteListener::class
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
    }
}
