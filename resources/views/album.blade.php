<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                @if($canImageAdded)
                    {{ __('theme.Album') }}
                @else
                    {{ $user->login }}
                @endif
            </h2>
            @if($canImageAdded)
                <a class="w-fit open_popup cursor-pointer inline-flex items-center px-4 py-2 bg-gray-800
                            dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white
                            dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white
                            focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300
                            focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2
                            dark:focus:ring-offset-gray-800 transition ease-in-out duration-150" data-target="add_photo">
                    {{ __('theme.Add Photo') }}
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100 flex flex-col gap-6">
                    @if($photos->count() > 0)
                        <div class="cards">
                            @foreach($photos as $photo)
                                {{ view("fragments.photo_card", compact('photo')) }}
                            @endforeach
                        </div>
                        {{ $photos->links() }}
                    @else
                        <div id="album_empty" class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                            <h2 class="text-center font-bold text-xl">{{ __('theme.Album empty') }}</h2>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div id="add_photo" class="popup hidden">
        <div class="window text-gray-900 dark:text-gray-100">
            <div class="popup-header">
                <h1 class="font-bold text-2xl">{{ __('theme.popup.Upload image') }}</h1>
                <svg width="24" height="24" class="popup-close" xmlns="http://www.w3.org/2000/svg"
                     xmlns:xlink="http://www.w3.org/1999/xlink" x="0px"
                     y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve" fill="white"><g><g><polygon points="512,59.076 452.922,0 256,196.922 59.076,0 0,59.076 196.922,256 0,452.922 59.076,512 256,315.076 452.922,512 512,452.922 315.076,256 "></polygon></g></g></svg>
            </div>
            <hr>
            <div class="popup-body">
                <form id="photo-upload" action="{{ route('album.store') }}">
                    @csrf
                    <div class="upload-container">
                        <input type="file" class="image-upload" name="image" accept="image/*">
                        <div class="preview-container">
                            <img class="preview hidden" src="">
                            <div class="upload">
                                <div class="upload-content">+</div>
                            </div>
                        </div>
                    </div>
                    <textarea type="text" name="comment" placeholder="{{ __('theme.popup.comment') }}"></textarea>
                </form>
            </div>
            <hr>
            <div class="popup-footer">
                <p class="error-message">{{ __('theme.popup.upload_image_required') }}</p>
                <button type="submit"
                        form="photo-upload"
                        class="cursor-pointer float-end inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200
                        border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800
                        uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700
                        dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2
                        focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out
                        duration-150 ms-3">
                    {{ __('theme.Add Photo') }}
                </button>
            </div>
        </div>
    </div>
</x-app-layout>
