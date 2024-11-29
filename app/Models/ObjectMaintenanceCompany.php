<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Customer;
use App\Models\Building;
use Carbon\Carbon;
use OwenIt\Auditing\Contracts\Auditable;

class ObjectMaintenanceCompany extends Model  implements Auditable
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;
     public $table = "object_maintenance_companies"; 
    
    protected $fillable = [
        'name','address','zipcode','phonenumber','email','place','active'
    ];
}
