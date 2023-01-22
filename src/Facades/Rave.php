<?php

/*
 * This file is part of the Laravel Rave package.
 *
 * (c) Edward Muss <edwardmuss5@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace EdwardMuss\Rave\Facades;

use Illuminate\Support\Facades\Facade;

class Rave extends Facade
{
    /**
     * Get the registered name of the component
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'flutterwave-laravel';
    }
}
