<?php

namespace App\Providers;

use App\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{

    /**
     * Hook in and check every request contains the api key
     *
     * @return void
     */
    public function boot()
    {

        $this->app['auth']->viaRequest('api', function ($request) {

          $request_token = $request->input('api_token');

          if ( $request_token && $request_token == env('API_TOKEN') ) {

              return $request;

          }

          return null;

        });
    }
}
