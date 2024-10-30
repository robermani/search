<?php
// config/routes.php
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return function (RoutingConfigurator $routes) {
    $routes->add('search', '/api/search')
        ->controller([App\Controller\SearchController::class, 'search'])
        ->methods(['GET']);
};
