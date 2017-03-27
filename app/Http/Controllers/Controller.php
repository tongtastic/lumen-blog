<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{

  /**
   * Returns json formatted response
   * @method jsonResponse
   * @return string json object of method response
   */
  public function jsonResponse( $response )
  {

    return response()->json([
      'success' => (bool) $response->success,
      'data' => $response->data
    ], (int) $response->response_code);

  }

}
