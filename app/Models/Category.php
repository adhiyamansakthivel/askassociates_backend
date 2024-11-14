<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;


class Category extends Model
{
    use HasFactory, HasUuids, HasSlug;

    protected $primaryKey = 'id';
    
    protected $keyType = 'string';
    public $incrementing = false;

   
    protected $fillable = [
        'name',
        'category_url',
    ];


    public function getRouteKeyName()
    {
        return 'category_url';
    }

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('category_url');
    }



    public function subcategories()
    {
        return $this->hasMany(SubCategory::class, 'category_id', 'id')->withTimestamps();
    }


    public function products()
    {
        return $this->hasMany(Product::class, 'category_id', 'id')->orderBy('created_at', 'DESC');
    }




}
