# Flutterwave Package for PHP Laravel)

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Total Downloads][ico-downloads]][link-downloads]


> Implement Flutterwave Rave payment gateway easily with Laravel framework

- Go to [Flutterwave](https://dashboard.flutterwave.com/dashboard/settings/apis) to get your public and private key


## Documentation

## Installation

### Prerequisite
<b>PHP, Laravel and composer</b>

To get the latest version of Flutterwave, simply use composer
```
composer require edwardmuss/flutterwave-laravel
```

## Configuration

Publish the configuration file using this command:
```
php artisan vendor:publish --provider="EdwardMuss\Rave\RaveServiceProvider"
```
A configuration-file named `flutterwave.php` will be placed in your `config directory`

Open your `.env` file and add your `public key`, `secret key`, `secret hash` like so:

Get your keys form [here](https://dashboard.flutterwave.com/dashboard/settings/apis)

```
FLW_PUBLIC_KEY=FLWPUBK-xxxxxxxxxxxxxxxxxxxxx-X
FLW_SECRET_KEY=FLWSECK-xxxxxxxxxxxxxxxxxxxxx-X
FLW_SECRET_HASH='My_lovelysite123'
```
- <b>FLW_PUBLIC_KEY</b> - This is the api public key gotten from your dashboard(compulsory)
- <b>FLW_SECRET_KEY</b> - This is the api secret key gotten from your dashboard(compulsory)
- <b>FLW_SECRET_HASH</b> - This is the secret hash for your webhook

## USage
### 1. Setup Routes
```
// The page that displays the payment form
Route::get('/', function () {
    return view('welcome');
});
// The route that the button calls to initialize payment
Route::post('/pay', [FlutterwaveController::class, 'initialize'])->name('paynow');
// The callback url after a payment
Route::get('/rave/callback', [FlutterwaveController::class, 'callback'])->name('callback');
```

2. Setup the Payment Page

A sample payment button will look like so:

    welcome.blade.php
```
<h3>Buy me Coffee</h3>
<form method="POST" action="{{ route('paynow') }}">
    {{ csrf_field() }}

    <input name="name" placeholder="Name" />
    <input name="email" type="email" placeholder="Your Email" />
    <input name="phone" type="tel" placeholder="Phone number" />

    <input type="submit" value="Buy me Coffee" />
</form>
```
#
3. Setup your Controller

    Setup your controller to handle the routes. I created the FlutterwaveController. Use the Rave as Flutterwave facade.

#
Example
```
<?php

namespace App\Http\Controllers;

use EdwardMuss\Rave\Facades\Rave as Flutterwave;

class FlutterwaveController extends Controller
{
    /**
     * Initialize Rave payment process
     * @return void
     */
    public function initialize()
    {
        //This generates a payment reference
        $reference = Flutterwave::generateReference();

        // Enter the details of the payment
        $data = [
            'payment_options' => 'card,banktransfer',
            'amount' => 500,
            'email' => request()->email,
            'tx_ref' => $reference,
            'currency' => "KES",
            'redirect_url' => route('callback'),
            'customer' => [
                'email' => request()->email,
                "phone_number" => request()->phone,
                "name" => request()->name
            ],

            "customizations" => [
                "title" => 'Buy Me Coffee',
                "description" => "Let express love of coffee"
            ]
        ];

        $payment = Flutterwave::initializePayment($data);


        if ($payment['status'] !== 'success') {
            // notify something went wrong
            return;
        }

        return redirect($payment['data']['link']);
    }

    /**
     * Obtain Rave callback information
     * @return void
     */
    public function callback()
    {
        
        $status = request()->status;

        //if payment is successful
        if ($status ==  'successful') {
        
        $transactionID = Flutterwave::getTransactionIDFromCallback();
        $data = Flutterwave::verifyTransaction($transactionID);

        dd($data);
        }
        elseif ($status ==  'cancelled'){
            //Put desired action/code after transaction has been cancelled here
        }
        else{
            //Put desired action/code after transaction has failed here
        }
        // Get the transaction from your DB using the transaction reference (txref)
        // Check if you have previously given value for the transaction. If you have, redirect to your successpage else, continue
        // Confirm that the currency on your db transaction is equal to the returned currency
        // Confirm that the db transaction amount is equal to the returned amount
        // Update the db transaction record (including parameters that didn't exist before the transaction is completed. for audit purpose)
        // Give value for the transaction
        // Update the transaction to note that you have given value for the transaction
        // You can also redirect to your success page from here

    }
}
```

## Credits

- [Edward Muss][link-author]
- [Cloud Rebue](https://github.com/cloudrebue)

## Contributing
Please feel free to fork this package and contribute by submitting a pull request to enhance the functionalities. I will appreciate that a lot. Also please add your name to the credits.

Kindly [follow me on Instagram](https://instagram.com/edwardmuss)!

## Features

The current features have been implemented

- Payment
- Verification
- Transfers
- Banks
- Beneficiaries


> If there are features you need urgently, I will be willing to prioritize them, please reach out to my twitter account
## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/edwardmuss/flutterwave-laravel.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/edwardmuss/flutterwave-laravel.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/edwardmuss/flutterwave-laravel
[link-downloads]: https://packagist.org/packages/edwardmuss/flutterwave-laravel
[link-author]: https://github.com/edwardmuss
[link-contributors]: ../../contributors
[link-code-intelligence]: https://scrutinizer-ci.com/code-intelligence
