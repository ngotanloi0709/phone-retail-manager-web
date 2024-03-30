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
        $data['isAuthenticated'] = $this->authenticationService->isAuthenticated();
        $data['isAdmin'] = $this->authenticationService->isAdmin();
        $data['currentUser'] = $this->authenticationService->getCurrentUser();
        echo $this->engine->render($template, $data);
    }
}