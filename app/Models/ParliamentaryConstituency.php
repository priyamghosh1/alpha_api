<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParliamentaryConstituency extends Model
{
    use HasFactory;
    protected $hidden = [
        "created_at","updated_at"
    ];

    public function districts(){
        // return $this->hasMany(District::class,'parliamentary_constituency_id');
        // return $this->hasMany('App\Models\District','parliamentary_constituency_id');
        return $this->hasMany(DistrictList::class,'parliamentary_constituency_id');
    }
}
