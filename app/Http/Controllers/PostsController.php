<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

class PostsController extends Controller
{

  protected $success = true;

  protected $data = [];

  protected $response_code = 200;

  /**
   * signifies which methods require auth in class
   * @method __construct
   */
  public function __construct()
  {

    $this->middleware('auth', [
      'only' => [
        'getAllPosts',
        'getPost',
        'deletePost',
        'insertPost',
        'updatePost'
      ]
    ]);

  }

/**
 * Return all posts from database
 * @method getAllPosts
 * @return string JSON containing all the posts
 */
  public function getAllPosts()
  {

    $posts = Post::all();

    if( !$posts || count( $posts ) == 0 ) {

      $this->success = false;

      $this->data = [
        'message' => (string) 'No posts found'
      ];

      $this->response_code = 404;

    } else {

      $this->success = true;

      foreach( $posts as $post )
      {

        $this->data[] = [
          'id' => (int) $post->id,
          'user_id' => (int) $post->user_id,
          'title' => (string) $post->title,
          'content' => (string) $post->content,
          'created_at' => $post->created_at->toDateTimeString(),
          'updated_at' => $post->updated_at->toDateTimeString()
        ];

      }

    }

    return $this->jsonResponse();

  }
/**
 * Return a post by ID
 * @method getPost
 * @param  Request $request Response class
 * @param  int $id id of required post
 * @return string JSON containg the post data
 */
  public function getPost( Request $request, $id )
  {

    $post = Post::find( $id );

    if( !$post ) {

      $this->success = false;

      $this->data = [
        'message' => (string) 'Post not found'
      ];

      $this->response_code = 404;

    } else {

      $this->data = [
        'id' => (int) $post->id,
        'user_id' => (int) $post->user_id,
        'title' => (string) $post->title,
        'content' => (string) $post->content,
        'created_at' => $post->created_at->toDateTimeString(),
        'updated_at' => $post->updated_at->toDateTimeString()
      ];

    }

    return $this->jsonResponse();

  }
/**
 * Deletes a post
 * @method deletePost
 * @param  Request $request Request class
 * @return string JSON containing deleted post id and success value
 */
  public function deletePost( Request $request )
  {

    $id = $request->input( 'id' );

    $post = Post::find( $id );

    if( !$post ) {

      $this->success = false;

      $this->data = [
        'message' => (string) 'Post not found'
      ];

      $this->response_code = 404;

    } else {

      $post->delete();

      $this->data = [
        'id' => (int) $post->id
      ];

    }

    return $this->jsonResponse();

  }
/**
 * Inserts a post to the DB
 * @method insertPost
 * @param  Request $request Request class
 * @return string JSON object of inserted post values
 */
  public function insertPost( Request $request )
  {

    $post = new Post;

    $post->user_id = $request->input( 'user_id' );

    $post->title = $request->input( 'title' );

    $post->content = $request->input( 'content' );

    $post->save();

    if( !$post ) {

      $this->success = false;

      $this->data = [
        'message' => (string) 'Post not inserted'
      ];

      $this->response_code = 500;

    } else {

      $this->data = [
        'id' => (int) $post->id,
        'user_id' => (int) $post->user_id,
        'title' => (string) $post->title,
        'content' => (string) $post->content,
        'created_at' => $post->created_at->toDateTimeString(),
        'updated_at' => $post->updated_at->toDateTimeString()
      ];

    }

    return $this->jsonResponse();

  }

  /**
   * [updatePost description]
   * @method updatePost
   * @param  Request $request [description]
   * @return {[type] [description]
   */
  public function updatePost( Request $request )
  {

    $id = $request->input( 'id' );

    $post = Post::find( $id );

    if( !$post ) {

      $this->success = false;

      $this->data = [
        'message' => (string) 'Post not found'
      ];

      $this->response_code = 404;

    } else {

      if( $request->input( 'user_id' ) )
      {

        $post->user_id = $request->input( 'user_id' );

      }

      if( $request->input( 'title' ) )
      {

        $post->title = $request->input( 'title' );

      }

      if( $request->input( 'content' ) )
      {

        $post->content = $request->input( 'content' );

      }

      $post->save();

      $this->data = [
        'id' => (int) $post->id,
        'user_id' => (int) $post->user_id,
        'title' => (string) $post->title,
        'content' => (string) $post->content,
        'created_at' => $post->created_at->toDateTimeString(),
        'updated_at' => $post->updated_at->toDateTimeString()
      ];

    }

    return $this->jsonResponse();

  }

  /**
   * Returns json formatted response
   * @method jsonResponse
   * @return string json object of method response
   */
  public function jsonResponse()
  {

    return response()->json([
      'success' => (bool) $this->success,
      'data' => $this->data
    ], (int) $this->response_code);

  }

}
