<?php

namespace Motwreen\Coupons;

use App\Product;
use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;
use Motwreen\Coupons\Models\Coupon;

class CouponsServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->publishes([
            __DIR__.'/../migrations/' => database_path('migrations')
        ], 'migrations');
    }

    public function boot()
    {
        foreach ($this->getAllModels() as $model){
            if(class_uses($model, 'Motwreen\Coupons\Traits\Couponable')){
                $model = new $model;
                Coupon::resolveRelationUsing($model->getTable(), function ($coupon)  use($model){
                    return $coupon->morphedByMany(get_class($model), 'couponable');
                });
            }
        }

        $this->loadMigrationsFrom(__DIR__ . '/../migrations/');
    }

    public function getAllModels()
    {
        $composer = json_decode(file_get_contents(base_path('composer.json')), true);
        $models = [];
        foreach ((array)data_get($composer, 'autoload.psr-4') as $namespace => $path) {
            $models = array_merge(collect(File::allFiles(base_path($path)))
                ->map(function ($item) use ($namespace) {
                    $path = $item->getRelativePathName();
                    return sprintf('\%s%s',
                        $namespace,
                        strtr(substr($path, 0, strrpos($path, '.')), '/', '\\'));
                })
                ->filter(function ($class) {
                    $valid = false;
                    if (class_exists($class)) {
                        $reflection = new \ReflectionClass($class);
                        $valid = $reflection->isSubclassOf(\Illuminate\Database\Eloquent\Model::class) &&
                            !$reflection->isAbstract();
                    }
                    return $valid;
                })
                ->values()
                ->toArray(), $models);
        }
        return $models;
    }
}
