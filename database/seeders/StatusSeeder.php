<?php

namespace Database\Seeders;

use App\Models\Configs\Status;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = [
            [
                "name" => "Activo",
                "prefix" => strtoupper("Active"),
                "level" => "1",
                "send_email" => true,
                "module_name" => null,
                "logable" => false,
                "delivered" => false,
                "shipped" => false,
                "paid" => false,
            ],
            [
                "name" => "Inactivo",
                "prefix" => strtoupper("Suspended"),
                "level" => "1",
                "send_email" => true,
                "module_name" => null,
                "logable" => false,
                "delivered" => false,
                "shipped" => false,
                "paid" => false,
            ],
            [
                "name" => "En espera de pago",
                "prefix" => strtoupper("Awaiting_cheque_payment"),
                "level" => "1",
                "send_email" => true,
                "module_name" => \App\Models\Sales\Order::class,
                "logable" => false,
                "delivered" => false,
                "shipped" => false,
                "paid" => false,
            ],
            [
                "name" => "Pago Aceptado",
                "prefix" => strtoupper("Payment_accepted"),
                "level" => "2",
                "send_email" => true,
                "module_name" => \App\Models\Sales\Order::class,
                "logable" => true,
                "delivered" => false,
                "shipped" => false,
                "paid" => true,
            ],
            [
                "name" => "Preparacion en progreso",
                "prefix" => strtoupper("Preparation_in_progress"),
                "level" => "1",
                "send_email" => true,
                "module_name" => \App\Models\Sales\Order::class,
                "logable" => true,
                "delivered" => true,
                "shipped" => false,
                "paid" => true,
            ],
            [
                "name" => "Enviado",
                "prefix" => strtoupper("Shipped"),
                "level" => "2",
                "send_email" => true,
                "module_name" => \App\Models\Sales\Order::class,
                "logable" => true,
                "delivered" => true,
                "shipped" => true,
                "paid" => true,
            ],
            [
                "name" => "Entregado",
                "prefix" => strtoupper("Delivered"),
                "level" => "2",
                "send_email" => false,
                "module_name" => \App\Models\Sales\Order::class,
                "logable" => true,
                "delivered" => true,
                "shipped" => true,
                "paid" => true,
            ],
            [
                "name" => "Cancelado",
                "prefix" => strtoupper("Canceled"),
                "level" => "3",
                "send_email" => true,
                "module_name" => \App\Models\Sales\Order::class,
                "logable" => false,
                "delivered" => false,
                "shipped" => false,
                "paid" => false,
            ],
            [
                "name" => "Reembolso",
                "prefix" => strtoupper("Refund"),
                "level" => "3",
                "send_email" => true,
                "module_name" => \App\Models\Sales\Order::class,
                "logable" => false,
                "delivered" => false,
                "shipped" => false,
                "paid" => false,
            ],
            [
                "name" => "Error en el pago",
                "prefix" => strtoupper("Payment_error"),
                "level" => "3",
                "send_email" => true,
                "module_name" => \App\Models\Sales\Order::class,
                "logable" => true,
                "delivered" => false,
                "shipped" => false,
                "paid" => false,
            ],
            [
                "name" => "En backorder (pagado)",
                "prefix" => strtoupper("On_backorder_paid"),
                "level" => "2",
                "send_email" => true,
                "module_name" => \App\Models\Sales\Order::class,
                "logable" => false,
                "delivered" => false,
                "shipped" => false,
                "paid" => true,
            ],
            [
                "name" => "En backorder (sin pagar)",
                "prefix" => strtoupper("On_backorder_unpaid"),
                "level" => "1",
                "send_email" => true,
                "module_name" => \App\Models\Sales\Order::class,
                "logable" => false,
                "delivered" => false,
                "shipped" => false,
                "paid" => false,
            ],
            [
                "name" => "Abierto",
                "prefix" => strtoupper("Open"),
                "level" => "1",
                "send_email" => true,
                "module_name" => null,
                "logable" => false,
                "delivered" => false,
                "shipped" => false,
                "paid" => false,
            ],
            [
                "name" => "Cerrado",
                "prefix" => strtoupper("Closed"),
                "level" => "1",
                "send_email" => true,
                "module_name" => null,
                "logable" => false,
                "delivered" => false,
                "shipped" => false,
                "paid" => false,
            ],
            [
                "name" => "Pausado",
                "prefix" => strtoupper("Paused"),
                "level" => "1",
                "send_email" => true,
                "module_name" => \App\Models\Catalogs\Product::class,
                "logable" => false,
                "delivered" => false,
                "shipped" => false,
                "paid" => false,
            ],
        ];

        foreach ($statuses as $status) {
            $new = new Status();
            foreach ($status as $key => $value) {
                $new->$key = $value;
            }
            $new->save();
        }
    }
}
