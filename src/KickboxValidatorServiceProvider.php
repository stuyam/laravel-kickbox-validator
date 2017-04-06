<?php

namespace StuYam\KickboxValidator;

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
        // allow publishing off the config
        $this->publishes([
            __DIR__.'/config/kickbox.php' => config_path('kickbox.php'),
        ], 'kickbox');

        // load translation files
        $this->loadTranslationsFrom(__DIR__ . '/lang', 'kickbox');

        $this->app->booted(function($app) {
            // get validator and translator
            $validator = $app['validator'];
            $translator = $app['translator'];

            // setup custom kickbox validator
            $validator->extend('kickbox', function($attribute, $value, $parameters, $validator){

                // fetch the api key from the config - which allows the config to be cached
                $kickboxApiKey = config('kickbox.api_key');

                // throw exception if the kickbox credentials are missing from the env
                if( $kickboxApiKey == null ) {
                    // throw the custom exception defined below
                    throw new KickboxCredentialsNotFoundException('Please provide a KICKBOX_API_KEY in your .env file.');
                }

                // get kickbox key from users env file
                $client = new Kickbox($kickboxApiKey);
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
        $this->mergeConfigFrom(
            __DIR__ . '/config/kickbox.php', 'kickbox'
        );
    }
}
