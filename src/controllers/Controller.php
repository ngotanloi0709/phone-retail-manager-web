<?php

namespace app\controllers;

use app\models\UserRole;
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
//        $_SESSION['logger'][] = isset($_SESSION['user']) ? $_SESSION['user']->getRoleString() == "user" : [];
//        $_SESSION['logger'][] = isset($_SESSION['user']) ? $_SESSION['user']->getRole() == UserRole::USER : [];

        $this->logSessionRemainTime();
        $this->logUserInformation();

        $_SESSION['user'] = $this->authenticationService->getCurrentUser();
        echo $this->engine->render($template, $data);
    }

    // below function are for dev purpose only
    private function logSessionRemainTime(): void
    {
        $_SESSION['LAST_ACTIVITY'] = time();
        $session_lifetime = ini_get('session.gc_maxlifetime');
        $remaining_time = $session_lifetime - (time() - $_SESSION['LAST_ACTIVITY']);
        $_SESSION['logger'][] = "Thời gian còn lại của phiên: " . $remaining_time/10 . " giây.";
    }

    private function logUserInformation(): void
    {
        if (isset($_SESSION['user'])) {
            $_SESSION['logger'][] = "Username: " . $_SESSION['user']->getUsername();
            $_SESSION['logger'][] = "Email: " . $_SESSION['user']->getEmail();
            $_SESSION['logger'][] = "Role: " . $_SESSION['user']->getRoleString();
        } else {
            $_SESSION['logger'][] = "Chưa đăng nhập";
        }
    }
}