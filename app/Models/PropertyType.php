<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Property;

class PropertyType extends Model
{
    protected $table = 'property_type';

    protected $fillable = [
        'name'
    ];

    public function properties()
    {
        return $this->hasMany(Property::class);
    }
}
