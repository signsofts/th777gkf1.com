<?php

use App\Controllers\GroupController;
use App\Controllers\HomeController;
use App\Controllers\Login;
use App\Models\MembersModel;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */




//  ---- ADMIN  GROUP  ------------------------
$routes->get('auth/signin', [Login::class, "index"], ['filter' => 'autoLoginFilter']);
$routes->get('ad', function () {
    return redirect()->to(base_url('auth/signin'));
});

$routes->group("admin", ['filter' => 'loginFilter'], function ($routes) {
    $routes->get("", [HomeController::class, "index"]);
    $routes->get("dashboard", [HomeController::class, "index"]);

    // admin mg
    $routes->group("setting", [], function ($routes) {
        $routes->get('env', 'EnvController::index');
        $routes->post('env/save', 'EnvController::save');
        $routes->get('env/delete/(:any)', 'EnvController::delete/$1');
    });




    $routes->group("g", ['filter' => 'loginFilter'], function ($routes) {
        // room
        $routes->get("v", [GroupController::class, "index"]);
        $routes->get("v/(.*)", [GroupController::class, "groupView"]);
        $routes->get("l/(.*)/(.*)", [\App\Controllers\GroupLiveController::class, "index"]);
        $routes->get("ld/(.*)/(.*)/(.*)", [\App\Controllers\GroupLiveController::class, "openCard"]);
        $routes->post("ld/openling/(.*)", [\App\Controllers\GroupLiveController::class, "openling"]);
        $routes->post("ld/stoping/(.*)", [\App\Controllers\GroupLiveController::class, "stoping"]);
    });


    $routes->group("m", ['filter' => 'loginFilter'], function ($routes) {
        // members
        $routes->get("", [\App\Controllers\MemberController::class, "index"]);
        $routes->get("v/(.*)", [\App\Controllers\MemberController::class, "show"]);
        $routes->post("setagent", [\App\Controllers\MemberController::class, "setagent"]);
    });

    $routes->group("b", ['filter' => 'loginFilter'], function ($routes) {
        // bank mg
        $routes->get("", [\App\Controllers\BankController::class, "index"]);
        $routes->get("approve", [\App\Controllers\PaymentController::class, "index"]);
        $routes->post("create", [\App\Controllers\BankController::class, "create"]);
        $routes->get("v/(:num)", [\App\Controllers\BankController::class, "show"]);
        $routes->group("statements", function ($routes) {
            $routes->post("create", [\App\Controllers\BankStatementsController::class, "create"]);
            $routes->post("delete", [\App\Controllers\BankStatementsController::class, "delete"]);
        });
    });




    $routes->group("ac", ['filter' => 'loginFilter'], function ($routes) {
        // admin mg
        $routes->get("", [\App\Controllers\AdminController::class, "index"]);
    });
    $routes->group("report", ['filter' => 'loginFilter'], function ($routes) {
        $routes->get("agent", [\App\Controllers\ReoprtsController::class, "agent"]);
        $routes->post("agent/sum", [\App\Controllers\ReoprtsController::class, "agentSum"]);
    });



});



$routes->get('/signout/(:any)', function ($type) {
    $session = session();
    $session->remove('token');

    $session->set('type', 'admin');
    $session->remove('ac_code');
    $session->remove('user');

    switch ($type) {
        case '2':
            return $this->respond(['msg' => "logout Successful", "status" => TRUE], 200);
        case '3':
            return ['msg' => "logout Successful", "status" => TRUE];
        default:
            return redirect()->to(base_url('auth/signin'));
    }

});



$routes->get("/", [\App\Controllers\LoginUsersController::class, "index"], ['filter' => 'loginUsersFilter']);
$routes->get('login', [\App\Controllers\LoginUsersController::class, "index"], []);
$routes->get('users/signin', [\App\Controllers\LoginUsersController::class, "index"], []);
$routes->post('users/signin', [\App\Controllers\LoginUsersController::class, "signin"], []);

$routes->get('customer/register', [\App\Controllers\LoginUsersController::class, "register"], []);
$routes->post('customer/register', [\App\Controllers\LoginUsersController::class, "signup"], []);

$routes->get('users/signin/callback', [\App\Controllers\LoginUsersController::class, "callback"], []);
$routes->group("users", ['filter' => 'loginUsersFilter'], function ($routes) {
    $routes->get('', [\App\Controllers\UsersController::class, "index"], []);
    $routes->get('signout/(.*)', [\App\Controllers\UsersController::class, "signout"], []);
    $routes->get('statements', [\App\Controllers\UsersController::class, "statements"], []);
    $routes->get('account', [\App\Controllers\UsersController::class, "account"], []);
});




