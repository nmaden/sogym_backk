<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Models\Application;
class ProductDuplicate extends Model
{
    protected $table = 'product_duplicate';


    public function images() {
        return $this->hasMany(ProductImage::class,'product_id','id');
    }

}
