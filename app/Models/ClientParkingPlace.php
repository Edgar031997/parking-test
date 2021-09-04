<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientParkingPlace extends Model
{
    use HasFactory;

    protected $table = 'client_parking_places';

    protected $fillable = [
        'client_id',
        'parking_id',
        'car_type',
        'start_parking',
        'end_parking',
    ];

    public function client(){
        return $this->hasOne(Client::class,'id' , 'client_id');
    }

    public function parking(){
        return $this->hasOne(ParkingPlace::class,'id' , 'parking_id');
    }
}
