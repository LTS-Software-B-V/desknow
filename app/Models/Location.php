<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use OwenIt\Auditing\Contracts\Auditable;
/**
 * Class Location
 *
 * @property $id
 * @property $created_at
 * @property $updated_at
 * @property $deleted_at
 * @property $name
 * @property $zipcode
 * @property $place
 * @property $address
 * @property $slug
 * @property $complexnumber
 * @property $management_id
 * @property $customer_id
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Location extends Model implements Auditable
{ 
 
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;
 
  
 

    // Validation rules for this model
    static $rules = [];

    // Number of items to be shown per page
    protected $perPage = 20;

    // Attributes that should be mass-assignable
    protected $fillable = [ 'surface',
    'levels',
    'gps_lon',
    'construction_year'
    ,'access_code'
    ,'gps_lat'
    ,'location_id','customer_id'
    ,'access_contact'
    ,'location_key_lock'
    ,'province'
    ,'municipality'
    ,'housenumber',
    'complexnumber',
    'image', 
    'building_type',
    'building_access_type_id','remark','building_type_id','name','zipcode','place','address','slug','complexnumber','management_id','customer_id'];

  
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function managementcompany()
    {
        return $this->hasOne(objectManagementCompany::class, 'id', 'management_id');
    }

    public function objects()
    {
        return $this->hasMany(Elevator::class,'address_id','id');
    }
    
    public function contacts()
    {
        return $this->hasMany(Contact::class,'location_id','id');
    }

    public function buildingType()
    {
        return $this->hasOne(objectBuildingType::class,'id','building_type_id');
    }



}
