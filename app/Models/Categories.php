<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Models\Purchase;

class Categories extends Model
{
    protected $table = 'categories';

    public function purchases() {
        return $this->hasMany(Purchase::class,'category_id','id');
    }
}
