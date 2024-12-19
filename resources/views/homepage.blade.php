<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Главная') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                <div class="p-6 text-gray-900">
                    <h3 class="text-2xl font-semibold text-gray-800 mb-6 border-b pb-2 border-gray-200">
                        Категории
                    </h3>
                    @if ($categories->count() > 0)
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                            @foreach ($categories as $category)
                                <a href="{{ route('threads.index', $category) }}"
                                    class="bg-gray-100 rounded-lg hover:shadow-md transition duration-200 ease-in-out block">
                                    <div class="p-4 flex items-center justify-center">
                                        <span
                                            class="text-lg font-medium text-gray-800 hover:text-blue-500 transition duration-200 ease-in-out text-center">
                                            {{ $category->name }}
                                        </span>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-600 italic">Пока нет ни одной категории.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
