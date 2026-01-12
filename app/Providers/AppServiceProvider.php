<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

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
        Schema::defaultStringLength(191);
         // Prevent automatic index creation for long strings
        Schema::disableForeignKeyConstraints();

        // Or force dynamic row format
        DB::statement('SET GLOBAL innodb_default_row_format=DYNAMIC');
        DB::statement('SET SESSION innodb_strict_mode=0');

    }
}
