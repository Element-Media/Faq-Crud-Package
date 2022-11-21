<?php

namespace Elementcore\Faq;

use Illuminate\Support\ServiceProvider;

class FaqServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPublishing();
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
    }


    /**
     * Register the package's publishable resources.
     *
     * @return void
     */
    private function registerPublishing()
    {
        if ($this->app->runningInConsole()) {

            $this->publishes([
                __DIR__ . '/migrations/2021_09_08_105604_create_faq_table.php' => database_path(
                    sprintf('migrations/%s_create_faq_table.php', date('Y_m_d_His'))
                ),
            ], 'migrations');

            $this->publishes([
                __DIR__ . '/lang' => resource_path('lang'),
            ], 'lang');

            $this->publishes([
                __DIR__ . '/views' => base_path('resources/views/elementcore/faq'),
            ], 'views');

            $this->publishes([
                __DIR__ . '/routes.php' => base_path('routes/faq.php'),
            ], 'routes');

            // $this->publishes([
            //     __DIR__ . '/Faq.php' => base_path('app/Models/Faq.php'),
            // ], 'models');
        }
    }
}
