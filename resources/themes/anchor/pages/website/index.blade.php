<?php
use function Laravel\Folio\{middleware, name};
middleware('auth');
name('website');

?>
<x-layouts.website>
    <x-app.container x-data class="lg:space-y-6" x-cloak>


        <x-app.heading title="Website" description="" :border="false" />

        <div class="flex flex-col w-full mt-6 space-y-5 md:flex-row lg:mt-0 md:space-y-0 md:space-x-5">

        </div>

        <div class="flex flex-col w-full mt-5 space-y-5 md:flex-row md:space-y-0 md:mb-0 md:space-x-5">

        </div>

        <div class="mt-5 space-y-5">
            @subscriber
                <div id="gjs" style="height: 600px; border: 1px solid #ddd;"></div>
                <div id="blocks"></div>

                <x-app.message-for-subscriber />
            @else
                <div id="gjs" style="height: 500px; border: 1px solid #ddd;"></div>
                <div id="blocks"></div>

                <p>This current logged in user has a <strong>{{ auth()->user()->roles()->first()->name }}</strong> role. To
                    upgrade, <a href="{{ route('settings.subscription') }}" class="underline">subscribe to a plan</a>.
                </p>
            @endsubscriber

            @admin
                <x-app.message-for-admin />
            @endadmin
        </div>
    </x-app.container>
</x-layouts.website>
