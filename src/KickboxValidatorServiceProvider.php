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
        $this->loadTranslationsFrom(__DIR__ . '/lang', 'kickbox');

        $this->app->booted(function($app) {
            // get validator and translator
            $validator = $app['validator'];
            $translator = $app['translator'];

            // setup custom kickbox validator
            $validator->extend('kickbox', function($attribute, $value, $parameters, $validator){
                // throw exception if the kickbox credentials are missing from the env
                if( env('KICKBOX_API_KEY') == null ) {
                    // throw the custom exception defined below
                    throw new KickboxCredentialsNotFoundException('Please provide a KICKBOX_API_KEY in your .env file.');
                }

                // get kickbox key from users env file
                $client = new Kickbox(env('KICKBOX_API_KEY', 'key'));
                return $client->kickbox()->verify($value)->body['result'] !== 'undeliverable';
            }, $translator->get('kickbox::validation.kickbox'));

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
