<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PersonType;

class PersonType extends Model
{
    use HasFactory;

    public function person_type(){
        return $this->belongsTo(PersonType::class,'person_type_id');
    }
}
