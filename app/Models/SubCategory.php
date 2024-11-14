<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
class SubCategory extends Model
{
    use HasFactory, HasUuids, HasSlug;


    protected $primaryKey = 'id';
    
    protected $keyType = 'string';
    public $incrementing = false;


    protected $fillable = [
        'name',
        'subcategory_url',
        'category_id',
    ];


    public function getRouteKeyName()
    {
        return 'subcategory_url';
    }

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('subcategory_url');
    }


    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }



    public function products()
    {
        return $this->hasMany(Product::class, 'subcategory_id', 'id')->withTimestamps();
    }


}
