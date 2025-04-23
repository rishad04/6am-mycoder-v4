<?php

namespace App\Models;

use App\Enums\BillingCycleEnum;
use Illuminate\Database\Eloquent\Model;

//Activity Log
use App\Traits\SystemActivityLogTrait;

class SubscriptionPlan extends Model
{
    use SystemActivityLogTrait;
    protected $table = 'subscription_plans';
    protected $guarded = [];

    protected $casts = [
        'billing_cycle' => BillingCycleEnum::class,
    ];

    //RELATIONAL METHOD
}
