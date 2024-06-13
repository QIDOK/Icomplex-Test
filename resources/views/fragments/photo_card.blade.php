<div class="cursor-pointer card bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg sm:max-w-sm" onclick="location.href='{{ route('album.view', $photo->id) }}'">
    <div class="author">{{ $photo->author->login }}</div>
    <div class="image" style="background-image: url({{ asset('storage') . '/photos/' . $photo->path }});"></div>
    <p class="comment">{!! $photo->parsedComment(200) !!}</p>
</div>
