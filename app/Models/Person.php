<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PersonType;

class Person extends Model
{
    use HasFactory;
    protected $hidden = [
        "created_at","updated_at"
    ];
    /**
     * @var mixed
     */
    private $polling_station_id;

    public function person_type(){
        return $this->belongsTo(PersonType::class,'person_type_id');
    }
}
