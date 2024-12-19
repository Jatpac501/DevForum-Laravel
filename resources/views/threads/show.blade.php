<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Просмотр треда') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                <div class="p-6 text-gray-900">
                    @if ($thread)
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
                            @if ($thread->is_removed)
                                <div class="mt-4 text-gray-700">[ Тред удален ]</div>
                                @if ((auth()->check() && auth()->user()->id === $thread->user_id) || auth()->user()->role === 'admin')
                                    <form method="POST" action="{{ route('threads.restore', $thread) }}"
                                        class="mt-4">
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
                                        <x-image-preview :imagePath="$thread->image_path" maxWidth="20dvw" />
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
                                    @if (auth()->check() && (auth()->user()->id === $thread->user_id || auth()->user()->role === 'admin'))
                                        <form method="POST" action="{{ route('threads.remove', $thread) }}"
                                            class="mt-4">
                                            @csrf
                                            <button type="submit"
                                                class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-red-800 border border-transparent rounded-md hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                                                Удалить
                                            </button>
                                        </form>
                                    @endif
                                    @if (auth()->check() && auth()->user()->role === 'admin')
                                        <form method="POST" action="{{ route('profile.ban', $thread->user) }}"
                                            class="mt-4">
                                            @csrf
                                            @if ($thread->user->role === 'blocked')
                                                <button type="submit"
                                                    class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-red-800 border border-transparent rounded-md hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                                                    Разблокировать
                                                </button>
                                            @else
                                                <button type="submit"
                                                    class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-red-800 border border-transparent rounded-md hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                                                    Заблокировать
                                                </button>
                                            @endif
                                        </form>
                                    @endif
                                </div>
                        </div>
                        <div class="mt-4">
                            <form method="POST" action="{{ route('comments.store', $thread) }}"
                                enctype="multipart/form-data" class="d-flex flex-column gap-4">
                                @csrf
                                <div class="mb-2">
                                    <x-input-label for="answer" :value="__('Оставить комментарий')"
                                        class="mb-1 font-medium text-gray-700" />
                                    <x-text-area id="answer"
                                        class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                        name="body" required></x-text-area>
                                    <x-input-error :messages="$errors->get('answer')" class="mt-2 text-red-500" />
                                </div>
                                <div class="mt-4">
                                    <x-file-input id="image" class="w-full text-black" name="image"
                                        placeholder="Файл не выбран" buttonText="Выберите изображение"
                                        accept="image/*" />
                                </div>
                                <x-primary-button
                                    class="px-4 py-2 mt-4 font-bold text-white bg-blue-500 rounded hover:bg-blue-700 focus:outline-none focus:shadow-outline">
                                    {{ __('Отправить') }}
                                </x-primary-button>
                            </form>
                        </div>
                    @endif
                    @if ($thread->comments->count() > 0)
                        <div class="mt-6">
                            @if (!empty($commentsPin))
                                <h4 class="mb-6 text-xl font-semibold text-gray-800">Закрепленные комментарии</h4>
                                @foreach ($commentsPin as $comment)
                                    <div class="p-4 mb-6 border border-gray-200 rounded-lg bg-gray-50"
                                        x-data="{ isEditing: false, imageInput: null }">
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
                                                <span
                                                    class="text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
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
                                                <form method="POST" action="{{ route('comments.update', $comment) }}"
                                                    enctype="multipart/form-data" class="d-flex flex-column gap-2">
                                                    @csrf
                                                    @method('PUT')
                                                    <x-text-area :value="$comment->body" name="body" required
                                                        class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></x-text-area>
                                                    @if ($comment->image_path)
                                                        <div class="mr-4 mt-4">
                                                            <x-image-preview :imagePath="$comment->image_path" maxWidth="100px" />
                                                        </div>
                                                    @endif
                                                    <div class="d-flex mt-2 gap-2">
                                                        <x-primary-button
                                                            class="px-4 py-2 font-bold text-white bg-blue-500 rounded hover:bg-blue-700 focus:outline-none focus:shadow-outline">Сохранить</x-primary-button>
                                                        <x-primary-button type="button"
                                                            @click.prevent="isEditing = false"
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
                                                                class="fa-solid fa-thumbtack-slash"
                                                                style="color: #ffffff;"></i>
                                                        </x-primary-button>
                                                    @else
                                                        <x-primary-button
                                                            class="px-4 py-2 mt-4 font-bold text-white bg-blue-500 rounded hover:bg-blue-700 focus:outline-none focus:shadow-outline"><i
                                                                class="fa-solid fa-thumbtack"
                                                                style="color: #ffffff;"></i>
                                                        </x-primary-button>
                                                    @endif
                                                </form>
                                            @endif
                                            @if (auth()->check() && auth()->user()->id === $comment->user_id && !$comment->is_removed)
                                                <x-primary-button type="button" @click="isEditing = true"
                                                    class="px-4 py-2 mt-4 font-bold text-white bg-blue-500 rounded hover:bg-blue-700 focus:outline-none focus:shadow-outline"><i
                                                        class="fa-regular fa-pen-to-square"
                                                        style="color: #ffffff;"></i>
                                                </x-primary-button>
                                            @endif
                                            @if ((auth()->check() && auth()->user()->id === $thread->user_id) || auth()->user()->role === 'admin')
                                                <form method="POST"
                                                    action="{{ route('comments.remove', $comment) }}">
                                                    @csrf
                                                    @if ($comment->is_removed)
                                                        <x-primary-button
                                                            class="px-4 py-2 mt-4 font-bold text-white bg-green-500 rounded hover:bg-green-700 focus:outline-none focus:shadow-outline">
                                                            <i class="fa-solid fa-trash-can-arrow-up"
                                                                style="color: #ffffff;"></i>
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
                                                <form method="POST"
                                                    action="{{ route('profile.ban', $comment->user) }}">
                                                    @csrf
                                                    @if ($comment->user->role === 'blocked')
                                                        <x-primary-button
                                                            class="px-4 py-2 mt-4 font-bold text-white bg-green-500 rounded hover:bg-green-700 focus:outline-none focus:shadow-outline">
                                                            <i class="fa-solid fa-user" style="color: #ffffff;"></i>
                                                        </x-primary-button>
                                                    @else
                                                        <x-primary-button
                                                            class="px-4 py-2 mt-4 font-bold text-white bg-red-500 rounded hover:bg-red-700 focus:outline-none focus:shadow-outline">
                                                            <i class="fa-solid fa-user-slash"
                                                                style="color: #ffffff;"></i>
                                                        </x-primary-button>
                                                    @endif
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                            <h4 class="mb-6 text-xl font-semibold text-gray-800">Комментарии</h4>
                            @foreach ($thread->comments as $comment)
                                <div class="p-4 mb-6 border border-gray-200 rounded-lg bg-gray-50"
                                    x-data="{ isEditing: false, imageInput: null }">
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
                                            <span
                                                class="text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
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
                                            <form method="POST" action="{{ route('comments.update', $comment) }}"
                                                enctype="multipart/form-data" class="d-flex flex-column gap-2">
                                                @csrf
                                                @method('PUT')
                                                <x-text-area :value="$comment->body" name="body" required
                                                    class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></x-text-area>
                                                @if ($comment->image_path)
                                                    <div class="mr-4 mt-4">
                                                        <x-image-preview :imagePath="$comment->image_path" maxWidth="100px" />
                                                    </div>
                                                @endif
                                                <div class="d-flex mt-2 gap-2">
                                                    <x-primary-button
                                                        class="px-4 py-2 font-bold text-white bg-blue-500 rounded hover:bg-blue-700 focus:outline-none focus:shadow-outline">Сохранить</x-primary-button>
                                                    <x-primary-button type="button"
                                                        @click.prevent="isEditing = false"
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
                                                            class="fa-solid fa-thumbtack-slash"
                                                            style="color: #ffffff;"></i>
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
                                                        <i class="fa-solid fa-trash-can-arrow-up"
                                                            style="color: #ffffff;"></i>
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
                            @endforeach
                        </div>
                    @else
                        <p class="mt-4 text-gray-600">Пока нет комментариев. <a href="#"
                                class="text-blue-500">Оставьте первый комментарий</a></p>
                    @endif
                @else
                    <p class="text-gray-600">Тред не найден.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <script>
        document.querySelectorAll("textarea").forEach(function(textarea) {
            textarea.style.height = textarea.scrollHeight + "px";
            textarea.style.overflowY = "hidden";
            textarea.addEventListener("input", function() {
                this.style.height = "auto";
                this.style.height = this.scrollHeight + "px";
            });
        });
    </script>
</x-app-layout>
