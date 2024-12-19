<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __($category->name) }}
        </h2>
    </x-slot>

    @if (!empty($threadsPin))
        <div class="pt-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                    <div class="p-6 text-gray-900">
                        <div class="d-flex flex-column gap-4">
                            <h3 class="text-lg font-medium text-gray-800 mb-6">
                                Закрепленные треды
                            </h3>
                            @foreach ($threadsPin as $thread)
                                <div class="p-4 bg-gray-100 rounded-lg mb-6">
                                    <h3 class="text-lg font-medium text-gray-800">
                                        <a href="{{ route('threads.show', $thread) }}"
                                            class="hover:text-blue-500"><x-markdown-text :content="$thread->title" /></a>
                                    </h3>
                                    <p class="mt-1 text-sm text-gray-600">
                                        {{ Str::limit($thread->body, 128) }}

                                    </p>
                                    <div
                                        class="d-flex justify-content-between align-items-center mt-2 text-xs text-gray-500">
                                        <span>Автор: {{ $thread->user->name }}</span>
                                        <span class="ml-2">Категория: {{ $thread->category->name }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                <div class="p-6 text-gray-900">

                    <div class="mb-6">
                        <x-link-button
                            class="bg-gray-800 border-gray-800 text-white hover:bg-gray-700 focus:ring-gray-500 "
                            href="{{ route('threads.create', $category) }}">
                            Создать новый тред
                        </x-link-button>
                    </div>
                    {{-- через !empty проверку сделай --}}
                    @if (!empty($threads))
                        <div class="d-flex flex-column gap-4">
                            @foreach ($threads as $thread)
                                <div class="p-4 bg-gray-100 rounded-lg mb-6">
                                    <h3 class="text-lg font-medium text-gray-800">
                                        <a href="{{ route('threads.show', $thread) }}"
                                            class="hover:text-blue-500"><x-markdown-text :content="$thread->title" /></a>
                                    </h3>
                                    <p class="mt-1 text-sm text-gray-600">
                                        {{ Str::limit($thread->body, 128) }}

                                    </p>
                                    <div
                                        class="d-flex justify-content-between align-items-center mt-2 text-xs text-gray-500">
                                        <span>Автор: {{ $thread->user->name }}</span>
                                        <span class="ml-2">Категория: {{ $thread->category->name }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        {{ $threads->links() }}
                    @else
                        <p class="text-gray-600">Пока нет ни одного треда. <a
                                href="{{ route('threads.create', $category) }}" class="text-blue-500">Создать первый
                                тред?</a></p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
