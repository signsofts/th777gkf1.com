<?php

use App\Controllers\Language;
// 
use App\Controllers\MessageLineApiController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->setAutoRoute ( FALSE );
$routes->useSupportedLocalesOnly ( TRUE );

$routes->get ( 'lang/{locale}', [ Language::class, 'index' ] );
$routes->match ( [ 'GET', 'POST' ], 'webhook', [ MessageLineApiController::class, 'webhook' ] );
$routes->match ( [ 'GET' ], 'wlog', [ MessageLineApiController::class, 'webhook_log' ] );
// $routes->match(['GET'], 'logm', [MessageLineApiController::class, 'logm']);

// $routes->get ( "mlog", [ MessageLineApiController::class, 'mlog' ] );

$routes->get ( 'l/(:any)', [ \App\Controllers\LnviteLinkController::class, 'index' ] );
$routes->get ( 'logm', [MessageLineApiController::class, 'logm'] );


$ControllersRoutes_path = ROOTPATH . 'app/Controllers/Routes';
if ( is_dir ( $ControllersRoutes_path ) ) {
    $ControllersRoutes = scandir ( $ControllersRoutes_path );
    foreach ( $ControllersRoutes as $Routes ) {

        if ( $Routes === '.' || $Routes === '..' ) {
            continue;
        }
        $route_path = $ControllersRoutes_path . '/' . $Routes;
        if ( file_exists ( $route_path ) ) {
            require $route_path;
        } else {
            continue;
        }
    }
}


// $routes->get ( 'image/(:any)/(:any)', 'ImageController::showImage/$1/$2' );
$routes->get ( 'image', 'ImageController::showImage' );
