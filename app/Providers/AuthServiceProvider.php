<?php

namespace App\Providers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{

    /**
     * Boot the authentication services for the application.
     *
     * @return void
     */
    public function boot()
    {
        $this->app['auth']->viaRequest('api', function ($request) {

          $request_token = $request->header('api_token');

          if ( $request_token && $request_token == env('API_TOKEN') ) {

              return $request;

          }

        });
    }
}
