<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Posts List') }}
        </h2>
    </x-slot>

    <div class="container">
        @livewire('post-table', [
            'headers' => $headers,
            'modelClass' => \App\Models\Post::class,
            'sortableFields' => $headers,
            'sortDirection' => 'asc'
        ])
    </div>
</x-app-layout>
