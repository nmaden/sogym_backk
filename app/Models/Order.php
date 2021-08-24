<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Spatie\Activitylog\Traits\LogsActivity;

class Order extends Model
{
    protected $table = 'order';

    public function info() {
        return $this->belongsTo(Ordered::class,'order_id','id');
    }
}
