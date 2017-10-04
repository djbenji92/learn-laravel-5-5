<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Contracts\Console\Kernel;
use DB;
use Faker\Factory;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected $baseUrl = 'http://localhost';
    protected $faker;

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
     public function createApplication()
     {
         $app = require __DIR__ . '/../bootstrap/app.php';
 
         $app->make(Kernel::class)->bootstrap();
 
         return $app;
     }

     public function setUp()
     {
         parent::setUp();
 
         $this->artisan('migrate');
 
         DB::table('users')->delete();
         DB::table('articles')->delete();
 
         $this->faker = Factory::create();
     }
}
