<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParkingPlace extends Model
{
    use HasFactory;

    protected $table = 'parking_places';

    protected $fillable = [
        'number',
        'price'
    ];

    public function clients_history(){
        return $this->belongsToMany(Client::class,'client_parking_places' , 'parking_id','client_id')
            ->withPivot('car_type','start_parking','end_parking');
    }
}
