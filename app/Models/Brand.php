<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;


class Brand extends Model
{
    use HasFactory, HasUuids, HasSlug;

    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;




    protected $fillable = [
        'logo',
        'name',
        'brand_url',
    ];


    public function getRouteKeyName()
    {
        return 'brand_url';
    }


    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('brand_url');
    }


    public function products()
    {
        return $this->hasMany(Product::class, 'brand_id', 'id')->orderBy('created_at', 'DESC');
    }


    
    



    



}
