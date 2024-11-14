<?php

namespace App\Models;

use App\Enums\ProductStatusEnum;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Product extends Model
{
    use HasFactory, HasUuids, HasSlug;


    protected $primaryKey = 'id';
    
    protected $keyType = 'string';
    public $incrementing = false;


    protected $fillable = [
        'title',
        'product_url',
        'description',
        'product_images',
        'brand_id',
        'category_id',
        'subcategory_id',
        'product_broucher',
        'price',
        'price_per',
        'tags',
        'status',
    ];



  


    protected $casts = [
        'status' => ProductStatusEnum::class,
        'product_images' => 'array',
        'tags' => 'array',
    ];


    public function getRouteKeyName()
    {
        return 'product_url';
    }

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('product_url');
    }


    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }


    public function subcategory()
    {
        return $this->belongsTo(SubCategory::class, 'subcategory_id', 'id');
    }



}
