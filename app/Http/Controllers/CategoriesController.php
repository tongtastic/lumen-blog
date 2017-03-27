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
          'created_at' => $category->created_at->toDateTimeString(),
          'updated_at' => $category->updated_at->toDateTimeString()
        ];

      }

    }

    return parent::jsonResponse( $this );

  }

}
