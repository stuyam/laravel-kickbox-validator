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
        $this->loadTranslationsFrom(__DIR__ . '/../../lang', 'kickbox');
        // $validator->extend('honeypot', 'honeypot@validateHoneypot', $translator->get('honeypot::validation.honeypot'));
        \Validator::extend('kickbox', function($attribute, $value, $parameters, $validator){
            $client = new Kickbox(env('KICKBOX_API_KEY', 'key'));
            return $client->kickbox()->verify($value)->body['result'] !== 'undeliverable';
        }, \Translator::get('honeypot::validation.honeypot'));
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
