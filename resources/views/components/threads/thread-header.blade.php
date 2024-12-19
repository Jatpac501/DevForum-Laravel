@props(['thread'])
<div class="p-4 bg-gray-100 rounded-lg">
    <h3 class="text-2xl font-bold text-gray-800"><x-markdown-text :content="$thread->title" /></h3>
    <div class="mt-2 text-sm text-gray-500 d-flex justify-content-between align-items-center">
        <span>Автор:
            @if ($thread->user->role === 'blocked')
                [ Заблокирован ]
            @else
                {{ $thread->user->name }}
            @endif
        </span>
        <span class="ml-2">Категория: {{ $thread->category->name }}</span>
        <span class="ml-2">Создано: {{ $thread->created_at->diffForHumans() }}</span>
    </div>
</div>
