<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory,Sluggable;

    protected $table = 'clients';

    protected $fillable = [
        'first_name',
        'second_name',
        'phone_number',
        'email'
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => ['first_name','second_name']
            ]
        ];
    }

    public function parkings_history(){
        return $this->belongsToMany(ParkingPlace::class,'client_parking_places' , 'client_id','parking_id')
            ->withPivot('car_type','start_parking','end_parking');
    }
}
