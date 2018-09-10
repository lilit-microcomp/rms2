<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Helpers\Contracts\CommentInterface;
use App\Helpers\Services\CommentService;

use Form;

use Illuminate\Contracts\Routing\ResponseFactory;

class CommentServiceProvider extends ServiceProvider
{
   /**
    * Bootstrap services.
    *
    * @return void
    */
   public function boot(ResponseFactory $response)
   {
        Form::component('commentComponent', 'comments.components.form', ['name', 'value', 'attributes']);
   }

   /**
    * Register services.
    *
    * @return void
    */
   public function register()
   {
       $this->app->singleton('App\Helpers\Contracts\CommentInterface', function () {
           return new CommentService();
       });
   }
}
