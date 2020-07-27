<?php

namespace App\Mail;

use App\Http\Repositories\OrderRepository;
use App\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderConfirmed extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The order instance.
     *
     * @var Order
     */
    public $order;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        /* $data = \App\Http\Repositories\OrderRepository->getOrder(request()->all(), $order);

        $order = $data['order'];
        $detail = $data['detail']; */

        return $this->markdown('emails.orderConfirmed');

        //return $this->view('view.emails.orderConfirmed');
    }
}
