<?php

namespace app\core;

use DI\Container;
use DI\DependencyException;
use DI\NotFoundException;
use FastRoute\Dispatcher;

class RequestHandler
{
    private Container $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function handle(): void
    {
        $dispatcher = $this->getDispatcher();

        if (!$dispatcher) {
            return;
        }

        $httpMethod = $_SERVER['REQUEST_METHOD'];
        $uri = $this->getUri();

        $routeInfo = $dispatcher->dispatch($httpMethod, $uri);
        $this->handleRoute($routeInfo);
    }

    private function getDispatcher()
    {
        try {
            return $this->container->get('dispatcher');
        } catch (DependencyException|NotFoundException $e) {
            error_log($e->getMessage());
            return null;
        }
    }

    private function getUri(): string
    {
        $uri = $_SERVER['REQUEST_URI'];

        if (false !== $pos = strpos($uri, '?')) {
            $uri = substr($uri, 0, $pos);
        }

        return rawurldecode($uri);
    }

    private function handleRoute(array $routeInfo): void
    {
        switch ($routeInfo[0]) {
            case Dispatcher::NOT_FOUND:
                // Handle 404
                break;
            case Dispatcher::METHOD_NOT_ALLOWED:
                $allowedMethods = $routeInfo[1];
                // Handle 405
                break;
            case Dispatcher::FOUND:
                $this->handleFoundRoute($routeInfo);
                break;
        }
    }

    private function handleFoundRoute(array $routeInfo): void
    {
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];

        list($class, $method) = explode("@", $handler, 2);
        $class = "\\app\\controllers\\" . $class;
        try {
            call_user_func_array([$this->container->get($class), $method], $vars);
        } catch (DependencyException|NotFoundException $e) {
            error_log($e->getMessage());
        }
    }
}