<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\View;
use App\Models\Notice;

class AppServiceProvider extends ServiceProvider
{
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
        View::composer('layouts.app', function ($view) {
            try {
                $view->with('globalNotices', \App\Models\Notice::where('is_active', true)->latest()->get());
            } catch (\Throwable $e) {
                $view->with('globalNotices', collect([]));
            }

            try {
                $view->with('websiteLinks', \App\Models\WebsiteLink::active()->ordered()->get());
            } catch (\Throwable $e) {
                $view->with('websiteLinks', collect([]));
            }

            try {
                $view->with('settings', \App\Models\Setting::first());
            } catch (\Throwable $e) {
                $view->with('settings', null);
            }
            
            // Fetch programs for admission status check in navbar
            try {
                $apiService = app(\App\Services\ExternalApiService::class);
                $programs = $apiService->getPrograms();
                if (isset($programs['error'])) {
                    $programs = [];
                }
                $view->with('admissionPrograms', $programs);
            } catch (\Throwable $e) {
                $view->with('admissionPrograms', []);
            }
        });

        View::composer('layouts.admin', function ($view) {
            try {
                $pages = \App\Models\CustomPage::orderBy('category')->orderBy('subcategory')->orderBy('page_name')->get();
                $groupedPages = $pages->groupBy('category')->map(function ($items) {
                    return $items->groupBy('subcategory');
                });
                $view->with('groupedCustomPages', $groupedPages);
            } catch (\Throwable $e) {
                $view->with('groupedCustomPages', collect([]));
            }
        });
    }
}
