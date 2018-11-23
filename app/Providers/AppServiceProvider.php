<?php

namespace SON\Providers;

use Faker\Factory as FakerFactory;
use Faker\Generator as FakerGenerator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        /**
         * regra de validação personalizado
         *
         */
        \Validator::extend('choice_true', function ($attributes, $value, $parameters, $validator){
            $items = collect($value)->filter(function ($item){
                return isset($item['true']) && $item['true'] !== false;
            });
            return $items->count() === 1;
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment() !== 'production') {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }

        $this->app->extend(FakerGenerator::class, function(){
            return FakerFactory::create('pt_BR');
        });
    }
}
