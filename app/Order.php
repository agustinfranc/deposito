<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    /* -------------------- */
	/* Relationships ------ */
	/* -------------------- */

    /**
     * Get the details for the order.
     */
    public function details()
    {
        return $this->hasMany('App\OrderDetail');
    }

    /**
     * Get the user record associated with the order.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Get the pay form record associated with the order.
     */
    public function payForm()
    {
        return $this->belongsTo('App\OrderPayForm');
    }

    /**
     * Get the status record associated with the order.
     */
    public function status()
    {
        return $this->belongsTo('App\OrderStatus');
    }
}
