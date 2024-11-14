<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    use HasFactory, HasUuids;

    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;




    protected $fillable = [
        'logo',
        'name',
        'email',
        'gst_number',
        'phone_one',
        'phone_two',
        'whatsapp',
        'address',
        'map',
        'open_hours'
    ];


    protected $casts = [
        'open_hours' => 'array',
      
    ];




}
