<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\PropertyType;
use App\Models\Enquery;


class Property extends Model
{
    protected $fillable = [
        'title',
        'description',
        'price',
        'property_type_id',
        'city',
        'image'
    ];


    public function type()
    {
        return $this->belongsTo(PropertyType::class, 'property_type_id');
    }


    public function enquiries()
    {
        return $this->hasMany(Enquery::class);
    }
}
