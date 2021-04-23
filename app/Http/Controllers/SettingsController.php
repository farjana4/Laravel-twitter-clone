<?php

namespace App\Http\Controllers;

use App\Events\EmailUpdated;
use App\Events\EmailUpdateRequested;
use App\Events\PhoneNumberUpdated;
use App\Events\PhoneNumberUpdateRequested;
use App\Events\UsernameUpdated;
use App\Http\Requests\SubmitOtpRequest;
use App\Http\Requests\UpdateEmailRequest;
use App\Http\Requests\UpdatePhoneNumberRequest;
use App\Http\Requests\UpdateUsernameRequest;
use App\Models\User;
use App\Services\SettingsService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Crypt;
use Tzsk\Otp\Facades\Otp;

class SettingsController extends Controller
{
    private SettingsService $settingsService;

    public function __construct(SettingsService $settingsService)
    {
        $this->settingsService = $settingsService;
    }

    public function showSettingsForm()
    {
        $data['user'] = auth()->user();

        return view('settings.settings', $data);
    }

    public function updateUsername(UpdateUsernameRequest $request): RedirectResponse
    {
        try {
            $this->settingsService->updateAttribute('username', $request->input('username'));
            event(new UsernameUpdated());

            $this->setSuccessNotification('Username updated Successfully');
        } catch (Exception $exception) {
            $this->setErrorNotification($exception->getMessage());
        }

        return redirect()->back();
    }

    public function updateEmail(UpdateEmailRequest $request): RedirectResponse
    {
        try {
            /* @var User $user */
            $user = auth()->user();
            $email = $request->input('email');

            if ($email !== $user->email) {
                event(new EmailUpdateRequested($email));
                $this->setSuccessNotification('Please check your new email address to update the email');
            } else {
                $this->setSuccessNotification('Email updated Successfully');
            }
        } catch (Exception $exception) {
            $this->setErrorNotification($exception->getMessage());
        }

        return redirect()->back();
    }

    public function changeEmail(String $token): RedirectResponse
    {
        $tokenString = Crypt::decryptString($token);
        $stringParts = explode('::', $tokenString);
        $email = $stringParts[0];
        $ttl = $stringParts[1];

        if (time() > $ttl) {
            $this->setErrorNotification('Try to update your email address again. Link expired.');
        }

        try {
            $this->settingsService->updateAttribute('email', $email);
            event(new EmailUpdated());

            $this->setSuccessNotification('Email Address updated Successfully');
        } catch (Exception $exception) {
            $this->setErrorNotification($exception->getMessage());
        }

        return redirect()->route('settings');
    }

    public function sendOtp(UpdatePhoneNumberRequest $request): RedirectResponse
    {
        try {
            /* @var User $user */
            $user = auth()->user();
            $phoneNumber = $request->input('phone_number');

            if ($phoneNumber !== $user->phone_number) {
                $token = Crypt::encryptString($phoneNumber);
                $otp = Otp::generate(sha1($user->email));

                event(new PhoneNumberUpdateRequested($phoneNumber, $otp));

                $this->setSuccessNotification('Please check your phone number for the OTP');

                return redirect()->route('settings.phone.otp', $token);
            } else {
                $this->setSuccessNotification('Phone number updated Successfully');
            }
        } catch (Exception $exception) {
            $this->setErrorNotification($exception->getMessage());
        }

        return redirect()->back();

        //update phone number without OTP
        /*try {
            $this->settingsService->updateAttribute('phone_number', $request->input('phone_number'));
            event(new PhoneNumberUpdateRequested($phoneNumber));

            $this->setSuccessNotification('Phone number updated Successfully');
        } catch (Exception $exception) {
            $this->setErrorNotification($exception->getMessage());
        }

        return redirect()->back();*/
    }

    public function showOtpForm(string $token)
    {
        $data['user'] = auth()->user();
        $data['token'] = $token;

        return view('settings.otp', $data);
    }

    public function updatePhoneNumber(string $token, SubmitOtpRequest $request): RedirectResponse
    {
        /* @var User $user */
        $user = auth()->user();
        //if(Otp::check($request->input('otp'), sha1($user->phone_number)) == false){
        if (Otp::check($request->input('otp'), sha1($user->email)) == false) {
            $this->setErrorNotification('Invalid or wrong OTP');

            return redirect()->back();
            //return redirect()->route('settings');
        }
        try {
            $phoneNumber = Crypt::decryptString($token);
            $this->settingsService->updateAttribute('phone_number', $phoneNumber);
            event(new PhoneNumberUpdated());

            $this->setSuccessNotification('Phone Number updated Successfully');
        } catch (Exception $exception) {
            $this->setErrorNotification($exception->getMessage());
        }

        return redirect()->route('settings');
    }
}
