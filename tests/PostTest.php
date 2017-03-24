<?php

use App\Post;
use Carbon\Carbon;
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

    $this->json('GET', '/posts/all', [
      'api_token' => $this->token
    ])
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

    $this->json('GET', '/posts/get/' . $post->id, [
      'api_token' => $this->token
    ])
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

    $this->json('POST', '/posts/delete', [
      'id' => $post->id,
      'api_token' => $this->token
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

    $this->json('PUT', '/posts/insert', [
      'title' => $post->title,
      'content' => $post->content,
      'user_id' => $post->user_id,
      'api_token' => $this->token
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
 * Generates a post, then updates post, checking database values match change
 * @method testUpdatePost
 */
  public function testUpdatePost()
  {

    $post = factory(Post::class)->create();

    $update_post = Post::find( $post->id );

    $new_title = 'update to this title';

    $new_content = 'update to this content';

    $time = Carbon::now()->toDateTimeString();

    $this->json('PUT', '/posts/update', [
      'id' => $post->id,
      'title' => $new_title,
      'content' => $new_content,
      'api_token' => $this->token
    ])
    ->seeJsonEquals([
      'success' => true,
      'data' => [
        'id' => (int) $post->id,
        'user_id' => (int) $post->user_id,
        'title' => (string) $new_title,
        'content' => (string) $new_content,
        'created_at' => $update_post->created_at->toDateTimeString(),
        'updated_at' => $this->time
      ]
    ])
    ->seeInDatabase('posts', [
      'id' => $update_post->id,
      'user_id' => $post->user_id,
      'title' => $new_title,
      'content' => $new_content,
      'created_at' => $post->created_at->toDateTimeString(),
      'updated_at' => $this->time
    ]);

  }

}
