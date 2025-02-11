<?php

use function Laravel\Folio\{middleware, name};
use function Livewire\Volt\{state, computed};
use App\Models\Program;
use App\Filament\Resources\ProgramResource;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Contracts\Pagination\Paginator;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Resources\Resource;

// middleware('auth');
name('programs');

?>

<x-layouts.app>
    <x-app.container x-data class="lg:space-y-6" x-cloak>
        <x-app.heading title="" description="" :border="false" />

        <div class=" ">

            @livewire(App\Filament\Resources\ProgramResource\Pages\ListPrograms::class)

        </div>



    </x-app.container>
</x-layouts.app>
