<?php

namespace App\Jobs\Orders;

use App\Models\Sales\Order;
use App\Models\User;
use App\Notifications\Orders\OrderCreated;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class NotifyUserOrderPlaced implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $user;
    public $order;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user, Order $order)
    {
        $this->user = $user;
        $this->order = $order;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->user->notify((new OrderCreated($this->order, $this->user)));
    }
}
