<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderPayForm extends Model
{
    public $incrementing = false;

    /* -------------------- */
	/* Relationships ------ */
	/* -------------------- */

    /**
     * Get the orders for the order pay form.
     */
    public function orders()
    {
        return $this->hasMany('App\Order');
    }

}
