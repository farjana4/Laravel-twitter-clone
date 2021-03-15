<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegistrationRequest;
use App\Services\AuthService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    private AuthService $authService;

    public function __construct(AuthService $authService){
        $this->authService = $authService;
    }

    public function showRegistrationForm(){
        $data['pageTitle'] = 'Register an account with us';

        return view('auth.register', $data);
    }

    public function processRegistration(RegistrationRequest $request): RedirectResponse{
        //dd($request, $request->all());
        try {
            $this->authService->register($request->validated());
            $this->setSuccessNotification('User registered. Please check your email to verify your account');

            return redirect()->route('login');
        }catch (Exception $exception){
            $this->setErrorNotification($exception->getMessage());

            return redirect()->back();
        }
    }

    public function showLoginForm(){
        $data['pageTitle'] = 'Login to your account';

        return view('auth.login', $data);
    }

    public function processLogin(LoginRequest $request){

    }

}
