<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'LandingController', ['as' => 'landing.index']);
$routes->get('shop', 'LandingController::shop', ['as' => 'landing.shop.index']);
$routes->get('shop/show/(:segment)', 'LandingController::showShop/$1', ['as' => 'landing.shop.show']);

// Keranjang
$routes->group('cart', [
    'filter' => 'login',
    'filter' => 'role:user',
], static function ($routes) {
    $routes->get('/', 'LandingController::cart', ['as' => 'landing.cart.index']);
    $routes->post('add', 'LandingController::addToCart', ['as' => 'landing.cart.add']);
    $routes->post('increase/(:num)', 'LandingController::increaseCartQuantity/$1', ['as' => 'landing.cart.increase']);
    $routes->post('decrease/(:num)', 'LandingController::decreaseCartQuantity/$1', ['as' => 'landing.cart.decrease']);
    $routes->post('(:num)', 'LandingController::destroyCart/$1', ['as' => 'landing.cart.destroy']);
    $routes->get('payment/(:num)', 'LandingController::payment/$1', ['as' => 'landing.cart.payment.index']);
    $routes->post('payment/create', 'LandingController::paymentCreate', ['as' => 'landing.cart.payment.create']);
    $routes->post('payment/upload', 'LandingController::paymentUpload', ['as' => 'landing.cart.payment.upload']);
    $routes->post('payment/update', 'LandingController::paymentUpdate', ['as' => 'landing.cart.payment.update']);
    $routes->get('payment/done', 'LandingController::paymentDone', ['as' => 'landing.cart.payment.done']);
});

$routes->group('dashboard', ['filter' => 'login'], static function ($routes) {

    // Admin
    $routes->group('admin', ['filter' => 'role:admin'], static function ($routes) {
        $routes->get('', 'AdminController', ['as' => 'admin.index']);

        $routes->get('products', 'AdminController::products', ['as' => 'admin.products.index']);
        $routes->get('products/create', 'AdminController::createProduct', ['as' => 'admin.products.create']);
        $routes->post('products/store', 'AdminController::storeProduct', ['as' => 'admin.products.store']);
        $routes->get('products/edit/(:segment)', 'AdminController::editProduct/$1', ['as' => 'admin.products.edit']);
        $routes->post('products/update/(:num)', 'AdminController::updateProduct/$1', ['as' => 'admin.products.update']);
        $routes->post('products/destroy/(:segment)', 'AdminController::destroyProduct/$1', ['as' => 'admin.products.destroy']);

        $routes->get('users', 'AdminController::users', ['as' => 'admin.users.index']);
        $routes->post('users/destroy/(:segment)', 'AdminController::destroyUser/$1', ['as' => 'admin.users.destroy']);

        $routes->get('orders', 'AdminController::orders', ['as' => 'admin.orders.index']);
        $routes->get('orders/show/(:num)', 'AdminController::showOrder/$1', ['as' => 'admin.orders.show']);
        $routes->post('orders/update/(:num)', 'AdminController::updateOrder/$1', ['as' => 'admin.orders.update']);

        $routes->get('profile', 'AdminController::profile', ['as' => 'admin.profile.index']);
        $routes->get('profile/edit', 'AdminController::editProfile', ['as' => 'admin.profile.edit']);
        $routes->post('profile/update', 'AdminController::updateProfile', ['as' => 'admin.profile.update']);

        $routes->get('reports', 'AdminController::reports', ['as' => 'admin.reports.index']);
        $routes->get('reports/preview', 'AdminController::previewReportPdf', ['as' => 'admin.reports.preview']);
        $routes->get('reports/export', 'AdminController::exportReportPdf', ['as' => 'admin.reports.export']);
    });

    // User
    $routes->group('user', ['filter' => 'role:user'], static function ($routes) {
        $routes->get('', 'UserController', ['as' => 'user.index']);

        $routes->get('orders', 'UserController::orders', ['as' => 'user.orders.index']);
        $routes->get('orders/show/(:num)', 'UserController::showOrder/$1', ['as' => 'user.orders.show']);
        $routes->post('orders/update/(:num)', 'UserController::updateOrder/$1', ['as' => 'user.orders.update']);

        $routes->get('profile', 'UserController::profile', ['as' => 'user.profile.index']);
        $routes->get('profile/edit', 'UserController::editProfile', ['as' => 'user.profile.edit']);
        $routes->post('profile/update', 'UserController::updateProfile', ['as' => 'user.profile.update']);
    });
});
