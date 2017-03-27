<?php

use App\Category;
use Carbon\Carbon;
use Faker\Factory;
use Laravel\Lumen\Testing\DatabaseTransactions;

class CategoryTest extends TestCase
{

  protected $token;

  use DatabaseTransactions;

  /**
   * builds token and sets time variable
   * @method __construct
   */
  function __construct() {

    $this->faker = Factory::create();

    $this->token = env('API_TOKEN');

    $this->time = Carbon::now()->toDateTimeString();

  }

  /**
   * Generates 5 categories then loops through the controller response checking  categories exist in returned JSON
   * @method testGetAllCategories
   */
  public function testGetAllCategories()
  {

    $categories = factory(Category::class, 5)->create();

    foreach( $categories as $category )
    {

      $data[] = [
        'id' => (int) $category->id,
        'title' => (string) $category->title,
        'description' => (string) $category->description,
        'created_at' => (string) $category->created_at->toDateTimeString(),
        'updated_at' => (string) $category->updated_at->toDateTimeString()
      ];

    }

    $this->json('GET', '/categories/all', [],  [
      'api_token' => $this->token
    ])
    ->seeJsonEquals([
      'success' => true,
      'data' => $data
    ]);

  }

}
