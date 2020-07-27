<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
    protected $table = 'order_statuses';

    public $incrementing = false;

    /* -------------------- */
	/* Relationships ------ */
	/* -------------------- */

    /**
     * Get the orders for the order status.
     */
    public function orders()
    {
        return $this->hasMany('App\Order');
    }
}
