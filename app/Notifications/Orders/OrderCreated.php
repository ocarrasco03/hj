<?php

namespace App\Notifications\Orders;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderCreated extends Notification
{
    use Queueable;

    private $order;
    private $user;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($order, $user)
    {
        $this->order = $order;
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Determine which queues should be used for each notification channel.
     *
     * @return array
     */
    public function viaQueues()
    {
        return [
            'mail' => 'mail-queue',
        ];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Tu pedido de HJAutopartes.com.mx #' . $this->order->id)
                    ->greeting('Hola ' . $this->user->first_name . ',')
                    ->line('Gracias por tu pedido. Tu solicitud será revisada contra disponibilidad de inventario, de ser confirmada recibirás un correo electrónico con más detalles. Información adicional.')
                    ->line('Los detalles de tu pedido se indican a continuación. ')
                    ->action('Seguir mi pedido', route('profile.order.show', $this->order->id))
                    ->line('Tienes 72 horas después de recibir tu correo de confirmación de envío, para solicitar tu factura electrónica Ver más detalles. Solicita tu factura electrónica (CFDI) en la página de detalles de pedido, en la sección de Mis Pedidos. ')
                    ->line('Dependiendo del tipo de envío que hayas elegido, puede tomar hasta 24 horas para que la información de rastreo esté disponible en tu cuenta.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'order_id' => $this->order->id,
            'amount' => $this->order->total,
        ];
    }
}

