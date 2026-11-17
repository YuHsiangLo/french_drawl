<?php
 
 use Illuminate\Foundation\Application;
 use Illuminate\Foundation\Configuration\Exceptions;
 use Illuminate\Foundation\Configuration\Middleware;
 
 return Application::configure(basePath: dirname(__DIR__))
     ->withRouting(
         web: __DIR__.'/../routes/web.php',
         api: __DIR__.'/../routes/api.php',
         commands: __DIR__.'/../routes/console.php',
     )
     ->withMiddleware(function (Middleware $middleware): void {
         // Set the locale from the session on every web request.
         $middleware->web(append: [
             \App\Http\Middleware\Language::class,
         ]);
 
         // Authenticated users hitting guest-only pages (e.g. /login) go to the admin dashboard.
         $middleware->redirectUsersTo('/admin');
     })
     ->withExceptions(function (Exceptions $exceptions): void {
         //
     })->create();
