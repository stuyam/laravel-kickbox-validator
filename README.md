#Lavarel Kickboc Validator
A kickbox email lookup validator for form requests in laravel.
This custom validator for Laravel uses the Kickbox Api to validate that an email actual exists. Not just if it has a specific format or not, but if the email is a real email registered email.

Also see: [Laravel Twilio Validator](https://packagist.org/packages/stuyam/laravel-twilio-validator) for phone number validation.

###Step 1
Install via composer:

```
composer require stuyam/laravel-kickbox-validator
```

###Step 2
Add to your config/app.php service provider list:

```php
StuYam\TwilioValidator\TwilioValidatorServiceProvider::class
```

###Step 3
Add to Twilio credentials to your .env file:

```
KICKBOX_API_KEY=xxxxxxxxxx

```


###Usage
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
