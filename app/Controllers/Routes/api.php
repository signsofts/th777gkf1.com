<?php

use App\Controllers\HomeController;
use App\Controllers\Register;
use CodeIgniter\Router\RouteCollection;
use App\Controllers\Login;

/**
 * @var RouteCollection $routes
 */

$routes->group("api", function ($routes) {
    // $routes->get('/', [HomeController::class, 'index']);
    $routes->group("v1", function ($routes) {
        $routes->post("login", [Login::class, "Login"]);
        // $routes->post("register", [Register::class, 'index']);
        $routes->get("checkLogin", [Login::class, "checkLogin"]);
        $routes->group("resource", ['filter' => 'authFilter'], function ($routes) {
            $routes->resource('group', ['controller' => 'Resources\GroupResource']);
            $routes->resource('member', ['controller' => 'Resources\MemberResource']);
            $routes->resource('bank', ['controller' => 'Resources\BankListResource']); //api/v1/resource/bank 
            $routes->resource('statements', ['controller' => 'Resources\BankStatementsResource']);
            $routes->resource('mstatements', ['controller' => 'Resources\MemberStatementsResource']);
            $routes->resource('admin', ['controller' => 'Resources\AdminResource']);
            $routes->resource('live', ['controller' => 'Resources\GroupLiveResource']);
            $routes->resource('card', ['controller' => 'Resources\GroupLiveCardOpenResource']);
            $routes->resource('lnvitelink', ['controller' => 'Resources\LnviteLinkResource']);
            $routes->resource('payment', ['controller' => 'Resources\PaymentResource']);
        });
    });
});
