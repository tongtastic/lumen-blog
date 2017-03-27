<?php

use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Support\Facades\Artisan;

abstract class TestCase extends Laravel\Lumen\Testing\TestCase
{

  protected $token;

  /**
   * builds token and sets time variable
   * @method __construct
   * @return void
   */
  function __construct() {

    $this->faker = Factory::create();

    $this->token = env('API_TOKEN');

    $this->time = Carbon::now()->toDateTimeString();

  }

  /**
   * Creates the application.
   *
   * @return \Laravel\Lumen\Application
   */
  public function createApplication()
  {

      return require __DIR__.'/../bootstrap/app.php';

  }
  /**
   * Sets up the app and DB
   * @method setUp
   * @return void
   */
  public function setUp()
  {

    parent::setUp();

    Artisan::call('migrate');

  }

  /**
   * resets app and DB
   * @method tearDown
   * @return void
   */
  public function tearDown()
  {

    Artisan::call('migrate:reset');

    parent::tearDown();

  }

}
