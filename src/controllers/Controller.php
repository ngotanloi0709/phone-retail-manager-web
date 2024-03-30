<?php

namespace app\controllers;

use app\services\AuthenticationService;
use League\Plates\Engine;

class Controller
{
    protected Engine $engine;
    protected AuthenticationService $authenticationService;

    public function __construct(Engine $engine, AuthenticationService $authenticationService)
    {
        $this->engine = $engine;
        $this->authenticationService = $authenticationService;
    }

    protected function render(string $template, array $data = []): void
    {
        $_SESSION['isAuthenticated'] = $this->authenticationService->isAuthenticated();
        $_SESSION['currentUser'] = $this->authenticationService->getCurrentUser();
        echo $this->engine->render($template, $data);
    }
}