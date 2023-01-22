<?php

namespace Tests\Unit;

use Tests\TestCase;
use EdwardMuss\Rave\Rave;

class RaveServiceProviderTests extends TestCase
{
    /**
     * Tests if service provider Binds alias "flutterwave-laravel" to \EdwardMuss\Rave\Rave
     *
     * @test
     */
    public function isBound()
    {
        $this->assertTrue($this->app->bound('flutterwave-laravel'));
    }
    /**
     * Test if service provider returns \Rave as alias for \EdwardMuss\Rave\Rave
     *
     * @test
     */
    public function hasAliased()
    {
        $this->assertTrue($this->app->isAlias("EdwardMuss\Rave\Rave"));
        $this->assertEquals('flutterwave-laravel', $this->app->getAlias("EdwardMuss\Rave\Rave"));
    }
}
