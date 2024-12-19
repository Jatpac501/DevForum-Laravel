@props(['thread'])
@if ($thread->is_removed)
    <div class="mt-4 text-gray-700">[ Тред удален ]</div>
    @if ((auth()->check() && auth()->user()->id === $thread->user_id) || auth()->user()->role === 'admin')
        <form method="POST" action="{{ route('threads.restore', $thread) }}" class="mt-4">
            @csrf
            <button type="submit"
                class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-red-800 border border-transparent rounded-md hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                Восстановить
            </button>
        </form>
    @endif
@else
    <div class="mt-4 text-gray-700">
        <x-markdown-text :content="$thread->body" />
    </div>
    @if ($thread->image_path)
        <div class="mt-4">
            <x-image-preview :imagePath="$thread->image_path" maxWidth="60dvw" />
        </div>
    @endif
    <div class="flex gap-3 flex-col sm:flex-row">
        @if (auth()->check() && auth()->user()->role === 'admin')
            <div class="mt-4">
                <form method="POST" action="{{ route('threads.pin', $thread) }}">
                    @csrf
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-gray-800 border border-transparent rounded-md hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        @if ($thread->is_pin)
                            Открепить
                        @else
                            Закрепить
                        @endif
                    </button>
                </form>
            </div>
        @endif
        @if (auth()->check() && auth()->user()->id === $thread->user_id)
            <div class="mt-4">
                <a href="{{ route('threads.edit', $thread) }}"
                    class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-gray-800 border border-transparent rounded-md hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    Редактировать
                </a>
            </div>
        @endif
        @if ((auth()->check() && auth()->user()->id === $thread->user_id) || auth()->user()->role === 'admin')
            <form method="POST" action="{{ route('threads.remove', $thread) }}" class="mt-4">
                @csrf
                <button type="submit"
                    class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-red-800 border border-transparent rounded-md hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                    Удалить
                </button>
            </form>
        @endif
    </div>
@endif
