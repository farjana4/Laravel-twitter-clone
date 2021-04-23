@extends('layouts.master')

@section('main')
    <div class="border border-t-0 flex-1 h-auto">
        <!--middle wall-->
        <div class="bg-white sticky top-0">
            <div class="flex">
                <div class="flex-1 m-2">
                    <h2 class="font-semibold px-4 py-2 text-gray-900 text-xl">
                        Update Phone Number (OTP)
                    </h2>
                </div>
            </div>
            <hr class="" />
        </div>
        <div>
            <!--Show Notification-->
            @include('partials._notification')

            <!--Edit PhoneNumber form-->
            <div class="mt-5">
                <form action="{{ route('settings.phone.otp', $token) }}" method="post">
                    @csrf
                    <div class="px-3">

                        <div class="mb-2">
                            <label
                                class="block font-bold mb-2 text-grey-darker text-sm" for="phone_number">
                                OTP
                                <input
                                    class="appearance-none border capitalize focus:outline-none focus:placeholder-blue-400 focus:ring-2 focus:ring-blue-400 focus:text-blue-400 h-12 px-3 py-2 rounded shadow text-xs w-full mt-2"
                                    value="{{ $user->phone_number}}"
                                    id="otp"
                                    name="otp"
                                    type="text"
                                    maxlength="6"
                                    placeholder="Enter lyour OTP"
                                    required/>
                            </label>
                        </div>

                        <div class="mb-2">
                            <button
                                class="bg-blue-400 hover:bg-blue-600 px-4 py-2 rounded-full text-sm text-white">
                                Submit OTP
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            {{--Edit PhoneNumber form end--}}

            <hr class="border-4" />

        </div>
    </div>
@stop
