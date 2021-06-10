<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Spatie\Activitylog\Traits\LogsActivity;

class Categories extends Model
{
    protected $table = 'categories';


    public function children()
    {
        return $this->hasMany(self::class, 'p_id')->with('children');
    }
}
