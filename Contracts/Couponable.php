<?php

namespace EFrame\Payment\Contracts;

use EFrame\Payment\Order;

interface Couponable
{
    /**
     * @param Order $order
     *
     * @return Order
     */
    public function redemption(Order $order);
}