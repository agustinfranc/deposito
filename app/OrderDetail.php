<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderDetail extends Model
{
    use SoftDeletes;

    protected $table = 'order_details';

    /* -------------------- */
	/* Relationships ------ */
	/* -------------------- */

    /**
     * Get the order record associated with the order detail.
     */
    public function order()
    {
        return $this->belongsTo('App\Order');
    }
}
