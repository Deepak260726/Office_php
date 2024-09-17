<?php

namespace App\Providers;

use Illuminate\Cache\NullStore;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //Add this custom validation rule.
        Validator::extend('alpha_spaces', function ($attribute, $value) {

            // This will only accept alpha and spaces.
            // If you want to accept hyphens use: /^[\pL\s-]+$/u.
            return preg_match('/^[\pL\s]+$/u', $value);

        });

        if (\App::environment('production') | \App::environment('staging')) {
            \URL::forceScheme('https');
        }

        Cache::extend( 'none', function( $app ) {
            return Cache::repository( new NullStore );
        } );
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $loader = AliasLoader::getInstance();
        $loader->alias('Illuminate\Cache\MemcachedStore', 'App\Overrides\MemcachedStore');

        // INFRA - API ECOM
        $this->app->singleton(\App\Infrastructure\Services\Interfaces\ICmaApiService::class, \App\Infrastructure\Services\CmaApiService::class);

        // LARA PARTNERS
        $this->app->bind(\App\Services\Interfaces\ILaraPartnerService::class, \App\Services\LaraPartnerService::class);
        $this->app->bind(\App\Repositories\Interfaces\ILaraPartnerRepository::class, \App\Repositories\LaraPartnerRepository::class);

        // LARA INVOICES
        $this->app->bind(\App\Services\Interfaces\ILaraInvoiceService::class, \App\Services\LaraInvoiceService::class);
        $this->app->bind(\App\Repositories\Interfaces\ILaraInvoiceRepository::class, \App\Repositories\LaraInvoiceRepository::class);

        // MUST SERVICE / ECOMMERCE
        $this->app->bind(\App\Services\Interfaces\IMustService::class, \App\Services\MustService::class);

        // FEATURES.BATCH
        $this->app->bind(\App\Features\Batch\Services\Interfaces\IBatchService::class, \App\Features\Batch\Services\BatchService::class);
        $this->app->bind(\App\Features\Batch\Repositories\Interfaces\IBatchRepository::class, \App\Features\Batch\Repositories\BatchRepository::class);

        // FEATURES.PRICING
        $this->app->bind(\App\Features\Pricing\Services\Interfaces\ILaraPricingService::class, \App\Features\Pricing\Services\LaraPricingService::class);
        $this->app->bind(\App\Features\Pricing\Repositories\Interfaces\ILaraPricingRepository::class, \App\Features\Pricing\Repositories\LaraPricingRepository::class);

        // FEATURES.PROJECTS
        $this->app->bind(\App\Features\Projects\Services\Interfaces\IProjectService::class, \App\Features\Projects\Services\ProjectService::class);
        $this->app->bind(\App\Features\Projects\Repositories\Interfaces\IProjectRepository::class, \App\Features\Projects\Repositories\ProjectRepository::class);

        // FEATURES.PROJECTS.PARTNERS
        $this->app->bind(\App\Features\Projects\Services\Interfaces\IProjectPartnerService::class, \App\Features\Projects\Services\ProjectPartnerService::class);
        $this->app->bind(\App\Features\Projects\Repositories\Interfaces\IProjectPartnerRepository::class, \App\Features\Projects\Repositories\ProjectPartnerRepository::class);

        // FEATURES.PROJECTS.ROADMAP
        $this->app->bind(\App\Features\Projects\Services\Interfaces\IProjectRoadmapService::class, \App\Features\Projects\Services\ProjectRoadmapService::class);
        $this->app->bind(\App\Features\Projects\Repositories\Interfaces\IProjectRoadmapRepository::class, \App\Features\Projects\Repositories\ProjectRoadmapRepository::class);

        // FEATURES.INVOICE
        $this->app->bind(\App\Features\Invoice\Services\Interfaces\ILaraInvoiceService::class, \App\Features\Invoice\Services\LaraInvoiceService::class);
        $this->app->bind(\App\Features\Invoice\Repositories\Interfaces\ILaraInvoiceRepository::class, \App\Features\Invoice\Repositories\LaraInvoiceRepository::class);
    }
}
