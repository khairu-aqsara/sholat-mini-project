<?php

namespace Khairu\Sholat\Routes;

use Exception;

/**
 * Class Router handles routing for different HTTP methods.
 */
class Router
{
    /**
     * Array to store routes grouped by HTTP methods.
     *
     * @var array
     */
    protected array $routes = [];

    /**
     * Adds a route for GET requests.
     *
     * @param string $route The route path.
     * @param string $controller The controller class name.
     * @param string $action The action method in the controller.
     * @return void
     */
    public function get(string $route, string $controller, string $action): void
    {
        $this->addRoute($route, $controller, $action, 'GET');
    }

    /**
     * Adds a route for POST requests.
     *
     * @param string $route The route path.
     * @param string $controller The controller class name.
     * @param string $action The action method in the controller.
     * @return void
     */
    public function post(string $route, string $controller, string $action): void
    {
        $this->addRoute($route, $controller, $action, 'POST');
    }

    /**
     * Dispatches the request to the corresponding controller action.
     *
     * @throws Exception If the route is not found.
     * @return void
     */
    public function dispatch(): void
    {
        $uri = strtok($_SERVER['REQUEST_URI'], '?');
        $method = $_SERVER['REQUEST_METHOD'];

        if (array_key_exists($method, $this->routes) && array_key_exists($uri, $this->routes[$method])) {
            $controller = $this->routes[$method][$uri]['controller'];
            $action = $this->routes[$method][$uri]['action'];

            $controller = new $controller();
            $controller->$action($_REQUEST);
        } else {
            http_response_code(404);
            exit();
        }
    }

    /**
     * Adds a route to the routes array.
     *
     * @param string $route The route path.
     * @param string $controller The controller class name.
     * @param string $action The action method in the controller.
     * @param string $method The HTTP method (GET or POST).
     * @return void
     */
    private function addRoute(string $route, string $controller, string $action, string $method): void
    {
        $this->routes[$method][$route] = [
            'controller' => $controller,
            'action' => $action
        ];
    }
}
