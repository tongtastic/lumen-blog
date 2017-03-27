<?php

use App\Category;
use Faker\Factory;

class CategoryTest extends TestCase
{


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
        'slug' => (string) $category->slug
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

  /**
   * Generates category, then checks category exists in response from controller
   * @method testGetCategory
   */
  public function testGetCategory()
  {

    $category = factory(Category::class)->create();

    $this->json('GET', '/categories/get/' . $category->id, [], [
      'api_token' => $this->token
    ])
    ->seeJsonEquals([
      'success' => true,
      'data' => [
        'id' => (int) $category->id,
        'title' => (string) $category->title,
        'description' => (string) $category->description,
        'slug' => (string) $category->slug
      ]
    ]);

  }

  /**
   * Generates a category then deletes it, checking id in response matches request
   * @method testDeleteCategory
   */
  public function testDeleteCategory()
  {

    $category = factory(Category::class)->create();

    $this->json('DELETE', '/categories/delete', [
      'id' => $category->id
    ], [
      'api_token' => $this->token
    ])
    ->seeJsonEquals([
      'success' => true,
      'data' => [
        'id' => $category->id
      ]
    ]);

  }

  /**
   * Inserts a category, then checks database for category
   * @method testInsertCategory
   */
  public function testInsertCategory()
  {

    $category = factory(Category::class)->make();

    $this->json('PUT', '/categories/insert', [
      'title' => $category->title,
      'description' => $category->description,
      'slug' => $category->slug
    ], [
      'api_token' => $this->token
    ])
    ->seeJsonEquals([
      'success' => true,
      'data' => [
        'id' => (int) 1,
        'title' => (string) $category->title,
        'description' => (string) $category->description,
        'slug' => (string) $category->slug
      ]
    ])
    ->seeInDatabase('categories', [
      'title' => $category->title,
      'description' => $category->description,
      'slug' => $category->slug
    ]);

  }
  /**
   * Generates a category, then updates category title, checking database values match change
   * @method testUpdateCategory
   */
  public function testUpdateCategoryTitle()
  {

    $category = factory(Category::class)->create();

    $update_category = Category::find( $category->id );

    $new_title = $this->faker->sentence;

    $this->json('PUT', '/categories/update', [
      'id' => $category->id,
      'title' => $new_title
    ], [
      'api_token' => $this->token
    ])
    ->seeJsonEquals([
      'success' => true,
      'data' => [
        'id' => (int) $category->id,
        'title' => (string) $new_title,
        'description' => (string) $category->description,
        'slug' => (string) $category->slug
      ]
    ])
    ->seeInDatabase('categories', [
      'id' => $update_category->id,
      'title' => $new_title,
      'description' => $category->description,
      'slug' => $category->slug
    ]);

  }

  /**
   * Generates a category, then updates category content, checking database values match change
   * @method testUpdateCategory
   */
  public function testUpdateCategoryContent()
  {

    $category = factory(Category::class)->create();

    $update_category = Category::find( $category->id );

    $new_description = $this->faker->paragraph;

    $this->json('PUT', '/categories/update', [
      'id' => $category->id,
      'description' => $new_description,
      'slug' => $category->slug
    ], [
      'api_token' => $this->token
    ])
    ->seeJsonEquals([
      'success' => true,
      'data' => [
        'id' => (int) $category->id,
        'title' => (string) $category->title,
        'description' => (string) $new_description,
        'slug' => (string) $category->slug
      ]
    ])
    ->seeInDatabase('categories', [
      'id' => $update_category->id,
      'title' => $category->title,
      'description' => $new_description,
      'slug' => $category->slug
    ]);

  }

  /**
   * Generates a category, then updates user_id, checking database values match change
   * @method testUpdateCategory
   */
  public function testUpdateCategoryUserId()
  {

    $category = factory(Category::class)->create();

    $update_category = Category::find( $category->id );

    $new_id = $this->faker->randomNumber;

    $this->json('PUT', '/categories/update', [
      'id' => $category->id,
      'user_id' => $new_id
    ], [
      'api_token' => $this->token
    ])
    ->seeJsonEquals([
      'success' => true,
      'data' => [
        'id' => (int) $category->id,
        'title' => (string) $category->title,
        'description' => (string) $category->description,
        'slug' => (string) $category->slug
      ]
    ])
    ->seeInDatabase('categories', [
      'id' => $update_category->id,
      'title' => $category->title,
      'description' => $category->description,
      'slug' => $category->slug
    ]);

  }

}
