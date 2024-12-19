@props(['comment'])
<div class="p-4 mb-6 border border-gray-200 rounded-lg bg-gray-50" x-data="{ isEditing: false, commentBody: '{{ $comment->body }}' }">
    <div class="d-flex justify-content-between align-items-center mb-2">
        @if ($comment->is_pin)
            <div class="text-gray-500 text-sm">Закрепленный комментарий</div>
        @endif
        <div class="d-flex align-items-center">
            <span>
                @if ($comment->user->role === 'blocked')
                    [ Заблокирован ]
                @else
                    {{ $comment->user->name }}
                @endif
            </span>
            <span class="text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
        </div>
    </div>
    @if ($comment->is_removed)
        <div class="mt-4 text-gray-700">[ Комментарий удален ]</div>
    @else
        <div x-show="!isEditing">
            <x-markdown-text :content="$comment->body" />
            @if ($comment->image_path)
                <div class="mr-4 mt-4">
                    <x-image-preview :imagePath="$comment->image_path" maxWidth="100px" />
                </div>
            @endif
        </div>
        <div x-show="isEditing">
            <form method="POST" action="{{ route('comments.update', $comment) }}" enctype="multipart/form-data"
                class="d-flex flex-column gap-2">
                @csrf
                @method('PUT')
                <x-text-area x-model="commentBody" name="body" required
                    class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></x-text-area>
                <div class="mt-4">
                    <x-file-input id="image" class="w-full text-black" name="image" placeholder="Файл не выбран"
                        buttonText="Выберите изображение" accept="image/*" />
                </div>
                <div class="d-flex mt-2 gap-2">
                    <x-primary-button
                        class="px-4 py-2 font-bold text-white bg-blue-500 rounded hover:bg-blue-700 focus:outline-none focus:shadow-outline">Сохранить</x-primary-button>
                    <x-primary-button type="button" @click.prevent="isEditing = false"
                        class="px-4 py-2 font-bold text-gray-700 bg-gray-200 rounded hover:bg-gray-300 focus:outline-none focus:shadow-outline">Отмена</x-primary-button>
                </div>
            </form>
        </div>
    @endif
    <div class="flex gap-3 " x-show="!isEditing">
        @if (auth()->check() &&
                (auth()->user()->id === $comment->user_id || auth()->user()->role === 'admin') &&
                !$comment->is_removed)
            <form method="POST" action="{{ route('comments.pin', $comment) }}">
                @csrf
                @if ($comment->is_pin)
                    <x-primary-button
                        class="px-4 py-2 mt-4 font-bold text-white bg-blue-500 rounded hover:bg-blue-700 focus:outline-none focus:shadow-outline"><i
                            class="fa-solid fa-thumbtack-slash" style="color: #ffffff;"></i>
                    </x-primary-button>
                @else
                    <x-primary-button
                        class="px-4 py-2 mt-4 font-bold text-white bg-blue-500 rounded hover:bg-blue-700 focus:outline-none focus:shadow-outline"><i
                            class="fa-solid fa-thumbtack" style="color: #ffffff;"></i>
                    </x-primary-button>
                @endif
            </form>
        @endif
        @if (auth()->check() && auth()->user()->id === $comment->user_id && !$comment->is_removed)
            <x-primary-button type="button" @click="isEditing = true"
                class="px-4 py-2 mt-4 font-bold text-white bg-blue-500 rounded hover:bg-blue-700 focus:outline-none focus:shadow-outline"><i
                    class="fa-regular fa-pen-to-square" style="color: #ffffff;"></i>
            </x-primary-button>
        @endif
        @if ((auth()->check() && auth()->user()->id === $thread->user_id) || auth()->user()->role === 'admin')
            <form method="POST" action="{{ route('comments.remove', $comment) }}">
                @csrf
                @if ($comment->is_removed)
                    <x-primary-button
                        class="px-4 py-2 mt-4 font-bold text-white bg-green-500 rounded hover:bg-green-700 focus:outline-none focus:shadow-outline">
                        <i class="fa-solid fa-trash-can-arrow-up" style="color: #ffffff;"></i>
                    </x-primary-button>
                @else
                    <x-primary-button
                        class="px-4 py-2 mt-4 font-bold text-white bg-red-500 rounded hover:bg-red-700 focus:outline-none focus:shadow-outline">
                        <i class="fa-solid fa-trash" style="color: #ffffff;"></i>
                    </x-primary-button>
                @endif
            </form>
        @endif
        @if (auth()->check() && auth()->user()->role === 'admin' && $comment->user->id !== Auth::id())
            <form method="POST" action="{{ route('profile.ban', $comment->user) }}">
                @csrf
                @if ($comment->user->role === 'blocked')
                    <x-primary-button
                        class="px-4 py-2 mt-4 font-bold text-white bg-green-500 rounded hover:bg-green-700 focus:outline-none focus:shadow-outline">
                        <i class="fa-solid fa-user" style="color: #ffffff;"></i>
                    </x-primary-button>
                @else
                    <x-primary-button
                        class="px-4 py-2 mt-4 font-bold text-white bg-red-500 rounded hover:bg-red-700 focus:outline-none focus:shadow-outline">
                        <i class="fa-solid fa-user-slash" style="color: #ffffff;"></i>
                    </x-primary-button>
                @endif
            </form>
        @endif
    </div>
</div>
