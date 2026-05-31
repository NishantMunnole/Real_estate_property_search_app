<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Property;

class Enquiry extends Model
{
    protected $fillable = [
        'property_id',
        'name',
        'email',
        'phone',
        'message'
    ];


    public function property()
    {
        return $this->belongsTo(Property::class, 'property_id');
    }
}
