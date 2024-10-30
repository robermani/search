<?php
// config/routes.php
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;
use App\Controller\HomeController;

return function (RoutingConfigurator $routes) {
    $routes->add('search', '/api/search')
        ->controller([App\Controller\SearchController::class, 'search'])
        ->methods(['GET']);

    $routes->add('home', '/')
        ->controller([HomeController::class, 'index'])
        ->methods(['GET']);
};
