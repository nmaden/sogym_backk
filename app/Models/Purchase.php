<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Models\Application;
class Purchase extends Model
{
    protected $table = 'purchases';

    public function applications() {
        return $this->hasMany(Application::class,'purcase_id','id');
    }
}
