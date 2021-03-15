<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    /**
     * Show the email verification notice.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    //need this method after login
    /*public function show(Request $request)
    {
        return $request->user()->hasVerifiedEmail()
            ? redirect($this->redirectPath())
            : view('auth.verify');
    }*/

    public function verify(Request $request): RedirectResponse
    {
        $id = $request->route('id');
        $hash = (string) $request->route('hash');
        $user = User::findOrFail($id);
        //using after login, checking user id
        /*if (! hash_equals((string) $request->route('id'), (string) $request->user()->getKey())) {
            throw new AuthorizationException;
        }
        if (! hash_equals((string) $request->route('hash'), sha1($request->user()->getEmailForVerification()))) {
            throw new AuthorizationException;
        }*/

        if (! hash_equals($hash, sha1($user->getEmailForVerification()))) {
            $this->setErrorNotification('Invalid verification Link');
        }
        //once time already verified but click on over the verification ling again
        if ($user->hasVerifiedEmail()) {
            return redirect()->route('login');
        }
        //Link is valid, now need to verify the user
        if ($user->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        $this->setSuccessNotification('User account verified.');

        return redirect()->route('login');
    }
}
