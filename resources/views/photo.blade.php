<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('theme.Post') . ' № ' . $photo->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden shadow-sm sm:rounded-lg">
                <div id="view" class="p-6 text-gray-900 dark:text-gray-100">
                    <img
                        src="{{ asset('storage') . "/photos/" . $photo->path }}"
                        class="open_popup"
                        data-target="fullsize_image"
                        alt="Изображение в профиле {{ $photo->author->login }}"
                    >
                    <div class="text-block">
                        <h2 class="author_name text-2xl font-bold">{{ $photo->author->login }}</h2>
                        <p class="created text-gray-500 dark:text-gray-400">{{ $photo->created_at }}</p>
                    </div>
                    <p class="comment">{!! $photo->parsedComment() !!}</p>
                </div>
            </div>
        </div>
    </div>

    <div id="fullsize_image" class="popup hidden">
        <div class="window">
            <img src="{{ asset('storage') . "/photos/" . $photo->path }}" alt="Изображение в профиле {{ $photo->author->login }}">
        </div>
    </div>
</x-app-layout>
