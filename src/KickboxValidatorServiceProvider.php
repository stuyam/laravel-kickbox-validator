<?php

namespace Yamartino\KickboxValidator;

use Illuminate\Support\ServiceProvider;
use \Kickbox\Client as Kickbox;
// use \Validator as Validator;

class KickboxValidatorServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // load translation files
        $this->loadTranslationsFrom(__DIR__ . '/lang', 'validation');

        $this->app->booted(function($app) {
            // Get validator and translator
            $validator = $app['validator'];
            $translator = $app['translator'];

            $validator->extend('kickbox', function($attribute, $value, $parameters, $validator){
                $client = new Kickbox(env('KICKBOX_API_KEY', 'key'));
                return $client->kickbox()->verify($value)->body['result'] !== 'undeliverable';
            }, $translator->get('validation.kickbox'));
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
