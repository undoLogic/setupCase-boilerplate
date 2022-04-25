<?php
/**
 * Routes configuration.
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * It's loaded within the context of `Application::routes()` method which
 * receives a `RouteBuilder` instance `$routes` as method argument.
 *
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

use Cake\Routing\Route\DashedRoute;
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;

return static function (RouteBuilder $routes) {
    /*
     * The default class to use for all routes
     *
     * The following route classes are supplied with CakePHP and are appropriate
     * to set as the default:
     *
     * - Route
     * - InflectedRoute
     * - DashedRoute
     *
     * If no call is made to `Router::defaultRouteClass()`, the class used is
     * `Route` (`Cake\Routing\Route\Route`)
     *
     * Note that `Route` does not do any inflections on URLs which will result in
     * inconsistently cased URLs when used with `{plugin}`, `{controller}` and
     * `{action}` markers.
     */
    $routes->setRouteClass(DashedRoute::class);

    $routes->scope('/', function (RouteBuilder $builder) {

        $builder->connect('/', ['controller' => 'Pages', 'action' => 'dashboard']);
       // $builder->connect('/', ['controller' => 'Users', 'action' => 'index']);
       // $builder->connect('/:language', ['controller' => 'Users', 'action' => 'index'],  array('language' => 'en_US|fr_CA')) ;
        $builder->connect('/logout', ['controller' => 'Users', 'action' => 'logout']);
        //$builder->connect('/users/login', ['controller' => 'Users', 'action' => 'login']);
        //$builder->connect('/:language/login', ['controller' => 'Users', 'action' => 'login']);

        //default naming
       // $builder->connect('/:language/:prefix/:controller/:action/*');

        // language prefix
        $builder->connect('/:language', array('controller' => 'Pages', 'action' => 'dashboard'), array('language' => 'en_US|fr_CA')) ;
        $builder->connect('/:language/:controller/:action/*', array(), array('language' => 'en_US|fr_CA'));
      //9/  $builder->connect('/:language/:plugin/', array('controller' => 'Users', 'action' => 'index'), array('language' => 'en_US|fr_CA', 'plugin' => 'admin'));
        $builder->connect('/:language/:controller', array('action' => 'index'), array('language' => 'en_US|fr_CA'));
       // $builder->connect('/:language', array('controller' => 'Pages', 'action' => 'dashboard'), array('language' => 'en_US|fr_CA')) ;

        /*
         * Connect catchall routes for all controllers.
         *
         * The `fallbacks` method is a shortcut for
         *
         * ```
         * $builder->connect('/{controller}', ['action' => 'index']);
         * $builder->connect('/{controller}/{action}/*', []);
         * ```
         *
         * You can remove these routes once you've connected the
         * routes you want in your application.
         */
        $builder->fallbacks();
    });

    $routes->prefix('admin', function (RouteBuilder $routes) {
       $routes->connect('/:controller', ['action' => 'index'])->setPatterns(['language' => 'en_US|fr_CA'])->setPersist(['language']) ;
     //  $routes->connect('/:language/:controller', ['action' => 'index'])->setPatterns(['language' => 'en_US|fr_CA'])->setPersist(['language']) ;
        $routes->connect('/:language/:controller/:action/*', [])->setPatterns(['language' => 'en_US|fr_CA']) ;
        $routes->fallbacks(DashedRoute::class);
    });


    $routes->prefix('staff', function (RouteBuilder $builder) {
        $builder->scope('/', function (RouteBuilder $builder) {
            $builder->connect('/:language/:controller/:action/*', [])->setPatterns(['language' => 'en_US|fr_CA']) ;
        });
    });










    /*
     * If you need a different set of middleware or none at all,
     * open new scope and define routes there.
     *
     * ```
     * $routes->scope('/api', function (RouteBuilder $builder) {
     *     // No $builder->applyMiddleware() here.
     *
     *     // Parse specified extensions from URLs
     *     // $builder->setExtensions(['json', 'xml']);
     *
     *     // Connect API actions here.
     * });
     * ```
     */
};
