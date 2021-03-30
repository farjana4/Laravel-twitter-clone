@extends('layouts.master')

@section('main')
    <div class="border border-t-0 flex-1 h-auto">
        <!--middle wall-->
        <div class="bg-white sticky top-0">
            <div class="flex">
                <div class="flex-1 m-2">
                    <h2 class="font-semibold px-4 py-2 text-gray-900 text-xl">
                        Translates
                    </h2>
                </div>
            </div>
            <hr class="" />
        </div>
        <div>
            <!--Show Notification-->
        @include('partials._notification')

        <!--Edit username form-->
        @include('partials._translate-list')
        {{--Edit username form end--}}

            <hr class="border-4" />

        </div>
    </div>
@stop
