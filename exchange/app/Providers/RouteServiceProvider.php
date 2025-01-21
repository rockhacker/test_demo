<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        $this->mapAdminRoutes();

        $this->mapAgentRoutes();

        $this->mapCustomizeRoutes();
        //
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware(['web', 'system_on','lang'])
            ->namespace($this->namespace)
            ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
            ->middleware(['system_on', 'lang', 'web'])
            ->namespace($this->namespace)
            ->group(base_path('routes/api.php'));
    }

    /**
     * Define the "admin" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapAdminRoutes()
    {
        Route::prefix('admin')
            ->middleware(['web','admin_host'])
            ->namespace($this->namespace)
            ->group(base_path('routes/admin.php'));
    }

    /**
     * Define the "agent" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapAgentRoutes()
    {
        Route::prefix('agent')
            ->middleware(['web', 'system_on'])
            ->namespace($this->namespace)
            ->group(base_path('routes/agent.php'));
    }

    protected function mapCustomizeRoutes()
    {
        $customize_routes = glob(base_path('routes/customize') . '/*.php');
        foreach ($customize_routes as $route_file) {
            ['filename' => $filename] = pathinfo($route_file);
            $router = Route::namespace($this->namespace);
            if ($filename == 'web') {
                $filename = '';
                $router->middleware('web');
            }
            $router->prefix($filename)->group($route_file);
        }
    }
}
