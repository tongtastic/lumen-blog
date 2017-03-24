<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

class PostsController extends Controller
{

  protected $success = false;

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

    return response()->json([
      'success' => true,
      'data' => $posts
    ]);

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
        'message' => 'Post not found'
      ];

      $this->response_code = 404;

    } else {

      $this->success = true;

      $this->data = [
        'id' => $post->id,
        'title' => $post->title,
        'content' => $post->content,
        'created_at' => $post->created_at->toDateString(),
        'updated_at' => $post->updated_at->toDateString()
      ];

    }

    return response()->json([
      'success' => $this->success,
      'data' => $this->data
    ], $this->response_code);

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

    $post->delete();

    return response()->json([
      'success' => true,
      'data' => [
        'id' => $post->id
      ]
    ]);

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

    $post->title = $request->input( 'title' );

    $post->content = $request->input( 'content' );

    $post->save();

    return response()->json([
      'success' => true,
      'data' => [
        'id' => $post->id,
        'title' => $post->title,
        'content' => $post->content,
        'created_at' => $post->created_at->toDateString(),
        'updated_at' => $post->updated_at->toDateString()
      ]
    ]);

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

    $post->title = $request->input( 'title' );

    $post->content = $request->input( 'content' );

    $post->save();

    return response()->json([
      'success' => true,
      'data' => [
        'id' => $post->id,
        'title' => $post->title,
        'content' => $post->content,
        'created_at' => $post->created_at->toDateString(),
        'updated_at' => $post->updated_at->toDateString()
      ]
    ]);

  }

}
