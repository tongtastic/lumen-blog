<?php

use App\Post;
use Laravel\Lumen\Testing\DatabaseTransactions;

class PostTest extends TestCase
{

  use DatabaseTransactions;
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

    $this->json('GET', '/posts/all')
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

    $this->json('GET', '/posts/get/' . $post->id)
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
      'id' => $post->id
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

    $post = factory(Post::class)->create();

    $this->json('PUT', '/posts/insert', [
      'title' => $post->title,
      'content' => $post->content
    ])
    ->seeJsonEquals([
      'success' => true,
      'data' => [
        'id' => $post->id+1,
        'title' => (string) $post->title,
        'content' => (string) $post->content,
        'created_at' => (string) $post->created_at->toDateString(),
        'updated_at' => (string) $post->updated_at->toDateString()
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

    $update_post->title = 'update to this title';

    $update_post->content = 'update to this content';

    $update_post->save();

    $this->seeInDatabase('posts', [
      'id' => $post->id,
      'title' => $update_post->title,
      'content' => $update_post->content,
      'created_at' => $update_post->created_at,
      'updated_at' => $update_post->updated_at
    ]);

  }

}
