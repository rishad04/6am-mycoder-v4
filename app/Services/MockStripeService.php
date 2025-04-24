<?php

namespace App\Services;

use App\Enums\StripePaymentStatusEnum;
use App\Models\StripePaymentSubscriptionStatus;

class MockStripeService
{

  protected static $apiKey;
  protected static $secret;

  public function __construct()
  {
    self::$apiKey = config('services.stripe.key');
    self::$secret = config('services.stripe.secret');
  }

  public static function createSubscription($user, $plan, $key)
  {
    if (!self::$apiKey || !self::$secret) {
      return [
        'status' => 'config_mismatch'
      ];
    }

    $payment_status = 'failed';

    // Set payment status based on the mock key
    switch ($key) {
      case 'mock_key':
        $payment_status = mt_rand(0, 1) === 1 ? 'success' : 'failed';
        break;
      case 'always_success':
        $payment_status = 'success';
        break;
      case 'always_fail':
        $payment_status = 'failed';
        break;
    }

    $payment_method = rand(0, 1) === 1 ? 'Visa' : 'MasterCard';


    return [
      'status' => $payment_status,
      'payment_status' => $payment_status
    ];
  }

  public static function cancelSubscription($subscriptionId)
  {
    return [
      'status' => 'canceled',
      'subscription_id' => $subscriptionId
    ];
  }

  public static function getSubscriptionStatus($subscriptionId)
  {
    return [
      'status' => 'active',
      'payment_status' => 'success',
      'subscription_id' => $subscriptionId
    ];
  }
}
