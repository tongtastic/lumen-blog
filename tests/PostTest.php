<?php

use App\Post;
use Carbon\Carbon;
use Laravel\Lumen\Testing\DatabaseTransactions;

class PostTest extends TestCase
{

  protected $token;

  use DatabaseTransactions;
/**
 * builds token
 * @method __construct
 */
  function __construct() {

    $this->token = env('API_TOKEN');

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
        'id' => $post->id,
        'title' => (string) $post->title,
        'content' => (string) $post->content,
        'created_at' => (string) $post->created_at->toDateString(),
        'updated_at' => (string) $post->updated_at->toDateString()
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
    ->seeJson([
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

    $time = Carbon::now()->toDateString();

    $this->json('PUT', '/posts/insert', [
      'title' => $post->title,
      'content' => $post->content,
      'api_token' => $this->token
    ])
    ->seeJsonEquals([
      'success' => true,
      'data' => [
        'id' => (int) 1,
        'title' => (string) $post->title,
        'content' => (string) $post->content,
        'created_at' => $time,
        'updated_at' => $time
      ]
    ])->seeInDatabase('posts', [
      'title' => $post->title,
      'content' => $post->content
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

    $time = Carbon::now()->toDateString();

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
        'title' => (string) $new_title,
        'content' => (string) $new_content,
        'created_at' => $update_post->created_at->toDateString(),
        'updated_at' => $time
      ]
    ])->seeInDatabase('posts', [
      'id' => $post->id,
      'title' => $new_title,
      'content' => $new_content,
      'created_at' => $update_post->created_at,
      'updated_at' => $update_post->updated_at
    ]);

  }

}
