<?php

namespace Yamartino\KickboxValidator;

use Illuminate\Support\ServiceProvider;
use \Kickbox\Client as Kickbox;

class KickboxValidatorServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \Validator::extend('kickbox', function($attribute, $value, $parameters, $validator){
            $client = new Kickbox(env('KICKBOX_API_KEY', 'key'));
            return $client->kickbox()->verify($value)->body['result'] !== 'undeliverable';
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
