<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function loans() {
        return $this->hasMany('App\Loan', 'item_id', 'id');
    }
}