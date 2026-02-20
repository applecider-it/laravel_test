<?php

namespace App\Http\Middleware;

use Illuminate\Auth\AuthenticationException;

use Illuminate\Auth\Middleware\Authenticate as BaseAuthenticate;

/**
 * 認証チェックのミドルウェア
 */
class Authenticate extends BaseAuthenticate
{
    /**
     * Handle an unauthenticated user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  array  $guards
     * @return never
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    protected function unauthenticated($request, array $guards)
    {
        throw new AuthenticationException(
            'Unauthenticated.',
            $guards,
            $request->expectsJson() ? null : $this->getRedirectUrl(current($guards)),
        );
    }

    /** 認証していないときに移動するページ */
    protected function getRedirectUrl(?string $guard)
    {
        return $guard === 'admin' ? route('admin.login') : route('login');
    }
}
