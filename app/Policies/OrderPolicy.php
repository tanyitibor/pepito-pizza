<?php

namespace App\Policies;

use App\User;
use App\Order;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function list(User $user)
    {
        return $user->hasPermission('see_orders');
    }

    public function see(User $user, Order $order)
    {
        return $order->user_id === $user->id || $user->hasPermission('see_orders');
    }

    public function update(User $user)
    {
        return $user->hasPermission('modify_orders');
    }
}
