<?php

use App\Post;
use Carbon\Carbon;
use Faker\Factory;
use Laravel\Lumen\Testing\DatabaseTransactions;

class PostTest extends TestCase
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
   * Generates 5 posts then loops through the controller response checking posts exist in returned JSON
   * @method testGetAllPosts
   */
  public function testGetAllPosts()
  {

    $posts = factory(Post::class, 5)->create();

    foreach( $posts as $post )
    {

      $data[] = [
        'id' => (int) $post->id,
        'user_id' => (int) $post->user_id,
        'title' => (string) $post->title,
        'content' => (string) $post->content,
        'created_at' => (string) $post->created_at->toDateTimeString(),
        'updated_at' => (string) $post->updated_at->toDateTimeString()
      ];

    }

    $this->json('GET', '/posts/' . $this->token . '/all')
    ->seeJsonEquals([
      'success' => true,
      'data' => $data
    ]);

  }

  /**
   * Generates post, then checks post exists in response from controller
   * @method testGetPost
   */
  public function testGetPost()
  {

    $post = factory(Post::class)->create();

    $this->json('GET', '/posts/' . $this->token . '/get/' . $post->id)
    ->seeJsonEquals([
      'success' => true,
      'data' => [
        'id' => (int) $post->id,
        'user_id' => (int) $post->user_id,
        'title' => (string) $post->title,
        'content' => (string) $post->content,
        'created_at' => (string) $post->created_at->toDateTimeString(),
        'updated_at' => (string) $post->updated_at->toDateTimeString()
      ]
    ]);

  }
  /**
   * Generates a post then deletes it, checking id in response matches request
   * @method testDeletePost
   */
  public function testDeletePost()
  {

    $post = factory(Post::class)->create();

    $this->json('DELETE', '/posts/' . $this->token . '/delete', [
      'id' => $post->id
    ])
    ->seeJsonEquals([
      'success' => true,
      'data' => [
        'id' => $post->id
      ]
    ]);

  }
  /**
   * Inserts a post, then checks database for post
   * @method testInsertPost
   */
  public function testInsertPost()
  {

    $post = factory(Post::class)->make();

    $this->json('PUT', '/posts/' . $this->token . '/insert', [
      'title' => $post->title,
      'content' => $post->content,
      'user_id' => $post->user_id
    ])
    ->seeJsonEquals([
      'success' => true,
      'data' => [
        'id' => (int) 1,
        'user_id' => (int) $post->user_id,
        'title' => (string) $post->title,
        'content' => (string) $post->content,
        'created_at' => $this->time,
        'updated_at' => $this->time
      ]
    ])
    ->seeInDatabase('posts', [
      'title' => $post->title,
      'user_id' => $post->user_id,
      'content' => $post->content,
      'created_at' => $this->time,
      'updated_at' => $this->time
    ]);

  }
  /**
   * Generates a post, then updates post title, checking database values match change
   * @method testUpdatePost
   */
  public function testUpdatePostTitle()
  {

    $post = factory(Post::class)->create();

    $update_post = Post::find( $post->id );

    $new_title = $this->faker->sentence;

    $time = Carbon::now()->toDateTimeString();

    $this->json('PUT', '/posts/' . $this->token . '/update', [
      'id' => $post->id,
      'title' => $new_title
    ])
    ->seeJsonEquals([
      'success' => true,
      'data' => [
        'id' => (int) $post->id,
        'user_id' => (int) $post->user_id,
        'title' => (string) $new_title,
        'content' => (string) $post->content,
        'created_at' => $update_post->created_at->toDateTimeString(),
        'updated_at' => $this->time
      ]
    ])
    ->seeInDatabase('posts', [
      'id' => $update_post->id,
      'user_id' => $post->user_id,
      'title' => $new_title,
      'content' => $post->content,
      'created_at' => $post->created_at->toDateTimeString(),
      'updated_at' => $this->time
    ]);

  }

  /**
   * Generates a post, then updates post content, checking database values match change
   * @method testUpdatePost
   */
  public function testUpdatePostContent()
  {

    $post = factory(Post::class)->create();

    $update_post = Post::find( $post->id );

    $new_content = $this->faker->paragraph;

    $time = Carbon::now()->toDateTimeString();

    $this->json('PUT', '/posts/' . $this->token . '/update', [
      'id' => $post->id,
      'content' => $new_content
    ])
    ->seeJsonEquals([
      'success' => true,
      'data' => [
        'id' => (int) $post->id,
        'user_id' => (int) $post->user_id,
        'title' => (string) $post->title,
        'content' => (string) $new_content,
        'created_at' => $update_post->created_at->toDateTimeString(),
        'updated_at' => $this->time
      ]
    ])
    ->seeInDatabase('posts', [
      'id' => $update_post->id,
      'user_id' => $post->user_id,
      'title' => $post->title,
      'content' => $new_content,
      'created_at' => $post->created_at->toDateTimeString(),
      'updated_at' => $this->time
    ]);

  }

  /**
   * Generates a post, then updates user_id, checking database values match change
   * @method testUpdatePost
   */
  public function testUpdatePostUserId()
  {

    $post = factory(Post::class)->create();

    $update_post = Post::find( $post->id );

    $new_id = $this->faker->randomNumber;

    $time = Carbon::now()->toDateTimeString();

    $this->json('PUT', '/posts/' . $this->token . '/update', [
      'id' => $post->id,
      'user_id' => $new_id
    ])
    ->seeJsonEquals([
      'success' => true,
      'data' => [
        'id' => (int) $post->id,
        'user_id' => (int) $new_id,
        'title' => (string) $post->title,
        'content' => (string) $post->content,
        'created_at' => $update_post->created_at->toDateTimeString(),
        'updated_at' => $this->time
      ]
    ])
    ->seeInDatabase('posts', [
      'id' => $update_post->id,
      'user_id' => $new_id,
      'title' => $post->title,
      'content' => $post->content,
      'created_at' => $post->created_at->toDateTimeString(),
      'updated_at' => $this->time
    ]);

  }

}
