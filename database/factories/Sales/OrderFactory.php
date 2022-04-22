<?php

namespace Database\Factories\Sales;

use App\Models\Configs\Status;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sales\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $userIds = User::all()->pluck('id')->toArray();
        $statusIds = Status::where('module_name', null)->pluck('id')->toArray();

        $subtotal = $this->faker->randomFloat(2,0,100000);
        $discount = $this->faker->randomFloat(2,0,($subtotal / 2));
        $tax = (($subtotal - $discount) * 16) / 100;

        return [
            'user_id' => $this->faker->randomElement($userIds),
            'status_id' => $this->faker->randomElement($statusIds),
            'subtotal' => $subtotal,
            'discount' => $discount,
            'tax' => $tax,
            'total' => $subtotal - $discount + $tax,
        ];
    }
}
