<?php

namespace app\core;

use app\middleware\authorizationMiddleware;
use app\utils\ErrorHandler;
use app\utils\RequestHelper;
use DI\Container;
use DI\DependencyException;
use DI\NotFoundException;
use FastRoute\Dispatcher;

class RequestHandler
{
    public function __construct(
        private readonly Container               $container,
        private readonly AuthorizationMiddleware $authorizationMiddleware
    )
    {
        //
    }

    /**
     * @throws DependencyException
     * @throws NotFoundException
     */
    public function handle(): void
    {
        $dispatcher = $this->container->get('dispatcher');
        $httpMethod = RequestHelper::getRequestMethod();
        $uri = RequestHelper::getUri();

        $routeInfo = $dispatcher->dispatch($httpMethod, $uri);

        $this->handleRoute($routeInfo);
    }

    /**
     * @throws DependencyException
     * @throws NotFoundException
     */
    private function handleRoute(array $routeInfo): void
    {
        switch ($routeInfo[0]) {
            case Dispatcher::NOT_FOUND:
                ErrorHandler::handleNotFound();
                break;
            case Dispatcher::METHOD_NOT_ALLOWED:
                $allowedMethods = $routeInfo[1];
                header("HTTP/1.0 405 Method Not Allowed");
                echo "Method not allowed. Allowed methods for this route are: " . implode(', ', $allowedMethods);
                break;
            case Dispatcher::FOUND:
                if ($this->authorizationMiddleware->isRequestAuthorized(RequestHelper::getUri())) {
                    $this->handleFoundRoute($routeInfo);
                    break;
                }

                header('Location: /login');
                break;
        }
    }

    /**
     * @throws DependencyException
     * @throws NotFoundException
     */
    private function handleFoundRoute(array $routeInfo): void
    {
        // require change password if needed
        if (isset($_SESSION['isNeededChangePassword'])
            && $_SESSION['isNeededChangePassword']
            && RequestHelper::getUri() !== '/user/change-password-first-time'
            && RequestHelper::getUri() !== '/logout'
            && RequestHelper::getUri() !== '/error-not-found'
        ){
            header('Location: /user/change-password-first-time');
            return;
        }

        // Controller@Function
        $handler = $routeInfo[1];
        // Variable parameters
        $vars = $routeInfo[2];

        // Get Location of  controller and handling method
        list($class, $method) = explode("@", $handler, 2);
        $class = "\\app\\controllers\\" . $class;

        // Create instance of controller and call method
        $handler = [$this->container->get($class), $method];

        // Call method with handler and parameters
        call_user_func_array($handler, $vars);
    }
}