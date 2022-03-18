<?php

namespace App\Packages\Shoppingcart\Contracts;

use App\Packages\Shoppingcart\CartItem;

interface Calculator
{
    /**
     * Get attribute
     *
     * @param string $attribute
     * @param \App\Packages\Shoppingcart\CartItem $cartItem
     * @return void
     */
    public static function getAttribute(string $attribute, CartItem $cartItem);
}
