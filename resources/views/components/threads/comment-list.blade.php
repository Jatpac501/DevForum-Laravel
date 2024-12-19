@props(['comments'])
<div class="mt-6">
    @if (count($comments) > 0)
        @foreach ($comments as $comment)
            <x-threads.comment-item :comment="$comment" />
        @endforeach
    @else
        <p class="mt-4 text-gray-600">Пока нет комментариев.</p>
    @endif
</div>
