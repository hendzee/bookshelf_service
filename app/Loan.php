<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    public function items() {
        return $this->belongsTo('App\Item', 'item_id', 'id');
    }
}
