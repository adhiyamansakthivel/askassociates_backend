<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory, HasUuids;

    protected $primaryKey = 'id';
    
    protected $keyType = 'string';
    public $incrementing = false;


    protected $fillable = [
        'title',
        'gal_image',
    ];
}
