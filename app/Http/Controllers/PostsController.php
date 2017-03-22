<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

class PostsController extends Controller
{
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

    $title = $request->input( 'title' );

    $content = $request->input( 'content' );

    $post = new Post;

    $post->title = $title;

    $post->content = $content;

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
