<?php

namespace app\middleware;

use app\services\AuthenticationService;

class AuthorizationMiddleware
{
    private array $publicRoutes = [
        '/',
        '/home',
        '/login',
        '/error-not-found',
//        '/register',
        '/logout',
        '/login-by-email'
    ];

    private array $adminRoutes = [
        '/admin',
        '/admin/',
        '/admin/user-management',
        '/admin/create-new-user',
        '/admin/send-login-email',
        '/admin/delete-user',
        '/admin/edit-user',
        '/admin/change-user-password',
    ];

    public function __construct(
        private readonly AuthenticationService $authenticationService
    )
    {
        foreach ($this->adminRoutes as $adminRoute) {
            if (in_array($adminRoute, $this->publicRoutes)) {
                throw new \InvalidArgumentException("Admin route '{$adminRoute}' cannot be a public route.");
            }
        }
    }

    public function isPublicRoute(string $uri): bool
    {
        return in_array($uri, $this->publicRoutes);
    }

    public function isAdminRoute(string $uri): bool
    {
        return in_array($uri, $this->adminRoutes);
    }

    public function isAuthenticated(): bool
    {
        return $this->authenticationService->isAuthenticated();
    }

    public function isAdmin(): bool
    {
        return $this->authenticationService->isAdmin();
    }

    public function isRequestAuthorized(string $uri): bool
    {
        if ($this->isPublicRoute($uri)) {
            return true;
        }

        if ($this->isAuthenticated()) {
            if ($this->isAdminRoute($uri)) {
                return $this->isAdmin();
            }

            return true;
        }

        return false;
    }
}