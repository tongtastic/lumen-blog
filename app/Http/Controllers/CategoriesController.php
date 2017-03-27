<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

class CategoriesController extends Controller
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
        'getAllCategories'
      ]
    ]);

  }

/**
 * Return all categories from database
 * @method getAllCategories
 * @return string JSON containing all the categories
 */
  public function getAllCategories()
  {

    $categories = Category::all();

    if( !$categories || count( $categories ) == 0 ) {

      $this->success = false;

      $this->data = [
        'message' => (string) 'No categories found'
      ];

      $this->response_code = 404;

    } else {

      $this->success = true;

      foreach( $categories as $category )
      {

        $this->data[] = [
          'id' => (int) $category->id,
          'title' => (string) $category->title,
          'description' => (string) $category->description,
          'slug' => (string) $category->slug
        ];

      }

    }

    return parent::jsonResponse( $this );

  }

  /**
   * Return a category by ID
   * @method getCategory
   * @param  Request $request Response class
   * @param  int $id id of required category
   * @return string JSON containg the category data
   */
  public function getCategory( Request $request, $id )
  {

    $category = Category::find( $id );

    if( !$category ) {

      $this->success = false;

      $this->data = [
        'message' => (string) 'Category not found'
      ];

      $this->response_code = 404;

    } else {

      $this->data = [
        'id' => (int) $category->id,
        'title' => (string) $category->title,
        'description' => (string) $category->description,
        'slug' => (string) $category->slug
      ];

    }

    return parent::jsonResponse( $this );

  }

  /**
   * Deletes a category
   * @method deleteCategory
   * @param  Request $request Request class
   * @return string JSON containing deleted category id and success value
   */
    public function deleteCategory( Request $request )
    {

      $id = $request->input( 'id' );

      $category = Category::find( $id );

      if( !$category ) {

        $this->success = false;

        $this->data = [
          'message' => (string) 'Category not found'
        ];

        $this->response_code = 404;

      } else {

        $category->delete();

        $this->data = [
          'id' => (int) $category->id
        ];

      }

      return parent::jsonResponse( $this );

    }

    /**
     * Inserts a category to the DB
     * @method insertCategory
     * @param  Request $request Request class
     * @return string JSON object of inserted category values
     */
      public function insertCategory( Request $request )
      {

        $category = new Category;

        $category->title = $request->input( 'title' );

        $category->description = $request->input( 'description' );

        $category->slug = $request->input( 'slug' );

        $category->save();

        if( !$category ) {

          $this->success = false;

          $this->data = [
            'message' => (string) 'Category not inserted'
          ];

          $this->response_code = 500;

        } else {

          $this->data = [
            'id' => (int) $category->id,
            'title' => (string) $category->title,
            'description' => (string) $category->description,
            'slug' => (string) $category->slug
          ];

        }

        return parent::jsonResponse( $this );

      }

      /**
       * [updateCategory description]
       * @method updateCategory
       * @param  Request $request [description]
       * @return {[type] [description]
       */
      public function updateCategory( Request $request )
      {

        $id = $request->input( 'id' );

        $category = Category::find( $id );

        if( !$category ) {

          $this->success = false;

          $this->data = [
            'message' => (string) 'Category not found'
          ];

          $this->response_code = 404;

        } else {

          if( $request->input( 'title' ) )
          {

            $category->title = $request->input( 'title' );

          }

          if( $request->input( 'description' ) )
          {

            $category->description = $request->input( 'description' );

          }

          if( $request->input( 'slug' ) )
          {

            $category->slug = $request->input( 'slug' );

          }

          $category->save();

          $this->data = [
            'id' => (int) $category->id,
            'title' => (string) $category->title,
            'description' => (string) $category->description,
            'slug' => (string) $category->slug
          ];

        }

        return parent::jsonResponse( $this );

      }

}
