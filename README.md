# Lavarel Kickbox Validator
[![Packagist](https://img.shields.io/packagist/v/stuyam/laravel-kickbox-validator.svg)](https://packagist.org/packages/stuyam/laravel-kickbox-validator)
[![Packagist](https://img.shields.io/packagist/dt/stuyam/laravel-kickbox-validator.svg)](https://packagist.org/packages/stuyam/laravel-kickbox-validator)

A kickbox.io email lookup validator for form requests in laravel.
This custom validator for Laravel uses the [kickbox.io](https://kickbox.io/) API to validate that an email actual exists. Not just if it has a specific format or not, but if the email is a real email registered email.

Also see: [Laravel Twilio Validator](https://github.com/stuyam/laravel-twilio-validator) for phone number validation.

## Step 1
Install via composer:

```
composer require stuyam/laravel-kickbox-validator
```

## Step 2
Add to your ```config/app.php``` service provider list:

```php
StuYam\KickboxValidator\KickboxValidatorServiceProvider::class
```

## Step 3
Add Kickbox credentials to your .env file:

```
KICKBOX_API_KEY=xxxxxxxxxx
```

## Step 4 (optional)
Publish the kickbox config with `php artisan vendor:publish --tag=kickbox`

## Usage
Add the string 'kickbox' to a form request rules or validator like so:

```php
<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class EmailFormRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|kickbox'
        ];
    }
}

```
