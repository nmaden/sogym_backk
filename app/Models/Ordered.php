<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Spatie\Activitylog\Traits\LogsActivity;

class Ordered extends Model
{
    protected $table = 'ordered';

    public function orders() {
        return $this->hasMany(Order::class,'order_id','id');
    }
}
