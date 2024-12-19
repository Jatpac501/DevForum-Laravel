@props(['thread'])

<form method="POST" action="{{ route('comments.store', $thread) }}" enctype="multipart/form-data"
    class="d-flex flex-column gap-4">
    @csrf
    <div class="mb-2">
        <x-input-label for="answer" :value="__('Оставить комментарий')" class="mb-1 font-medium text-gray-700" />
        <x-text-area id="answer"
            class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
            name="body" required></x-text-area>
        <x-input-error :messages="$errors->get('answer')" class="mt-2 text-red-500" />
    </div>
    <div class="mt-4">
        <x-file-input id="image" class="w-full text-black" name="image" placeholder="Файл не выбран"
            buttonText="Выберите изображение" accept="image/*" />
    </div>
    <x-primary-button
        class="px-4 py-2 mt-4 font-bold text-white bg-blue-500 rounded hover:bg-blue-700 focus:outline-none focus:shadow-outline">
        {{ __('Отправить') }}
    </x-primary-button>
</form>
