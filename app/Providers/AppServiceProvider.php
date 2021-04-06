<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * @OA\Info(
     *      version="1.0.0",
     *      title="VUTTR (Very Useful Tools to Remember)",
     *      description="Vuttr OpenApi documentation",
     *      @OA\Contact(
     *          email="marcelo.motta@gmail.com"
     *      )
     * )
     */

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
