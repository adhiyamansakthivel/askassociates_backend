<?php 

namespace App\Traits;
use Illuminate\Support\Str;


trait Sluggable {
    public static function boot()
    {
        parent::boot();
        
        static::saving(function (self $model) {
            $model->slugColumn = Str::slug($model->{$model->sluggable});
            $model->save();
        });
    }
}