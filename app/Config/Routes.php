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
        $routes->get('', 'Admin', ['as' => 'admin.index']);

        $routes->get('products', 'Admin::products', ['as' => 'admin.products.index']);
        $routes->get('products/create', 'Admin::createProduct', ['as' => 'admin.prodducts.create']);
        $routes->post('products/store', 'Admin::storeProduct', ['as' => 'admin.products.store']);
        $routes->get('products/edit/(:segment)', 'Admin::editProduct/$1', ['as' => 'admin.products.edit']);
        $routes->post('products/update/(:num)', 'Admin::updateProduct/$1', ['as' => 'admin.products.update']);
        $routes->post('products/destroy/(:segment)', 'Admin::destroyProduct/$1', ['as' => 'admin.products.destroy']);

        $routes->get('users', 'Admin::users', ['as' => 'admin.users.index']);
        $routes->post('users/destroy/(:segment)', 'Admin::destroyUser/$1', ['as' => 'admin.users.destroy']);

        $routes->get('orders', 'Admin::orders', ['as' => 'admin.orders.index']);
        $routes->get('orders/show/(:num)', 'Admin::showOrder/$1', ['as' => 'admin.orders.show']);
        $routes->post('orders/update/(:num)', 'Admin::updateOrder/$1', ['as' => 'admin.orders.update']);

        $routes->get('profile', 'Admin::profile', ['as' => 'admin.profile.index']);
        $routes->get('profile/edit', 'Admin::editProfile', ['as' => 'admin.profile.edit']);
        $routes->post('profile/update', 'Admin::updateProfile', ['as' => 'admin.profile.update']);

        $routes->get('reports', 'Admin::reports', ['as' => 'admin.reports.index']);
        $routes->get('reports/preview', 'Admin::previewReportPdf', ['as' => 'admin.reports.preview']);
        $routes->get('reports/export', 'Admin::exportReportPdf', ['as' => 'admin.reports.export']);
    });

    // User
    $routes->group('user', ['filter' => 'role:user'], static function ($routes) {
        $routes->get('', 'User', ['as' => 'user.index']);

        $routes->get('orders', 'User::orders', ['as' => 'user.orders.index']);
        $routes->get('orders/show/(:num)', 'User::showOrder/$1', ['as' => 'user.orders.show']);

        $routes->get('profile', 'User::profile', ['as' => 'user.profile.index']);
        $routes->get('profile/edit', 'User::editProfile', ['as' => 'user.profile.edit']);
        $routes->post('profile/update', 'User::updateProfile', ['as' => 'user.profile.update']);
    });
});
