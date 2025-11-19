<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Database\Eloquent\Relations\Relation;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFour();

        Relation::enforceMorphMap([
            'sale' => 'App\Models\Sale',
            'user' => 'App\Models\User',
            'sale_return' => \App\Models\SaleReturn::class,
            'category' => \App\Models\Category::class,
            'item' => \App\Models\Item::class,
            'warehouse' => \App\Models\Warehouse::class,
            'client' => \App\Models\Client::class,
            'client_account_transaction' => \App\Models\ClientAccountTransaction::class,
            'safe_transaction' => \App\Models\SafeTransaction::class,
            'warehouse_transaction' => \App\Models\WarehouseTransaction::class,
        ]);
    }
}
