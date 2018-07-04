<?php

namespace App\Providers;

use App\Models\Categories;
use App\Models\Orders;
use App\Models\Products;
use App\Observers\CategoryObserver;
use App\Observers\OrderObserver;
use App\Observers\ProductObserver;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        Categories::observe(CategoryObserver::class);
        Products::observe(ProductObserver::class);
        Orders::observe(OrderObserver::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
