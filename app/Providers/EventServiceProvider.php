<?php

namespace App\Providers;

use App\Events\CouponCodeActived;
use App\Events\OrderPaid;
use App\Events\RechargePaid;
use App\Events\RefreshPaged;
use App\Listeners\ChangeUsed;
use App\Listeners\ChangeVipExpir;
use App\Listeners\CheckDoc;
use App\Listeners\UpdateUserJctimes;
use App\Listeners\UpdateVipExpirAt;
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
        \SocialiteProviders\Manager\SocialiteWasCalled::class => [
            // add your listeners (aka providers) here
            'SocialiteProviders\Weixin\WeixinExtendSocialite@handle'
        ],
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
//        RefreshPaged::class => [
//            UpdateVipExpirAt::class,
//        ],
        OrderPaid::class => [
            CheckDoc::class
        ],
        RechargePaid::class => [
            UpdateUserJctimes::class,
        ],
        CouponCodeActived::class => [
            ChangeUsed::class
        ],
        RefreshPaged::class => [
            ChangeVipExpir::class
        ],
        Invited::class => [
            ActiveVip::class
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
