<?php

namespace App\Services;

class MockStripeService
{
  public static function createSubscription($user, $plan, $key)
  {
    // Simulate a payment success or failure based on plan or other logic
    $payment_status = 'failed'; // Default

    if ($key === 'mock_key') {
      $payment_status = rand(0, 1) === 1 ? 'success' : 'failed';
    } elseif ($key === 'always_success') {
      $payment_status = 'success';
    } elseif ($key === 'always_fail') {
      $payment_status = 'failed';
    }


    return [
      'status' => $payment_status,
      'subscription_id' => uniqid('sub_'), // Simulating a subscription ID
      'payment_status' => $payment_status
    ];
  }

  public static function cancelSubscription($subscriptionId)
  {
    // Simulate a cancel request
    return [
      'status' => 'canceled',
      'subscription_id' => $subscriptionId
    ];
  }

  public static function getSubscriptionStatus($subscriptionId)
  {
    // Simulate fetching subscription status
    return [
      'status' => 'active', // Could be 'active', 'canceled', 'expired'
      'payment_status' => 'success', // Could be 'success', 'failed'
      'subscription_id' => $subscriptionId
    ];
  }
}
