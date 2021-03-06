<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\ApiController;
use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends ApiController
{
    /**
     * Auth Service.
     *
     * @var \App\Services\AuthService
     */
    private $auth;

    /**
     * AuthController constructor.
     *
     * @param \App\Services\AuthService $auth
     */
    public function __construct(AuthService $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Authenticate a user against email and password.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Dingo\Api\Http\Response
     */
    public function login(Request $request)
    {
        $token = $this->auth->authenticate($request->only('email', 'password'));

        return $this->response->array(compact('token'));
    }

    /**
     * Refresh an expired token.
     *
     * @return \Dingo\Api\Http\Response
     */
    public function refresh()
    {
        $token = $this->auth->refresh();

        return $this->response->array(compact('token'));
    }

    /**
     * Invalidate a token.
     *
     * @return \Dingo\Api\Http\Response
     */
    public function logout()
    {
        $this->auth->invalidate();

        return $this->response->noContent();
    }

    /**
     * Get the current authenticated user.
     *
     * @return \Dingo\Api\Http\Response
     */
    public function currentUser()
    {
        $user = $this->auth->user();

        return $this->response->array($user);
    }
}
