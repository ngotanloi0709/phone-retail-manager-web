<?php

namespace app\core;

use app\middleware\authorizationMiddleware;
use app\services\AuthenticationService;
use app\utils\RequestHelper;
use DI\Container;
use DI\DependencyException;
use DI\NotFoundException;
use FastRoute\Dispatcher;
use http\Header;

class RequestHandler
{
    private Container $container;
    private authorizationMiddleware $authorizationMiddleware;
    private AuthenticationService $authenticationService;

    public function __construct(Container $container, authorizationMiddleware $authorizationMiddleware, AuthenticationService $authenticationService)
    {
        $this->container = $container;
        $this->authorizationMiddleware = $authorizationMiddleware;
        $this->authenticationService = $authenticationService;
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

    private function handleRoute(array $routeInfo): void
    {
        switch ($routeInfo[0]) {
            case Dispatcher::NOT_FOUND:
                header('Location: /error');
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
                exit();
        }
    }

    private function handleFoundRoute(array $routeInfo): void
    {
        // Controller@Function
        $handler = $routeInfo[1];
        // Variable parameters
        $vars = $routeInfo[2];

        list($class, $method) = explode("@", $handler, 2);
        $class = "\\app\\controllers\\" . $class;

        // print to console
        error_log($class);

        try {
            $handler = [$this->container->get($class), $method];

            call_user_func_array($handler, $vars);
        } catch (DependencyException|NotFoundException $e) {
            error_log($e->getMessage());
        }
    }

//    private function attachValuesToResponse(mixed $vars): void
//    {
//        $isAuthenticated = $this->authorizationMiddleware->isAuthenticated();
//        $user = $isAuthenticated ? $this->authenticationService->getCurrentUser() : null;
//
//        $vars['isAuthenticated'] = $isAuthenticated;
//        $vars['currentAuthenticatedUser'] = $user;
//    }
}