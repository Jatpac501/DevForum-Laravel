<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Редактирование') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                <div class="p-6 bg-white border-b border-gray-200">

                    <form method="POST" action="{{ route('threads.update', $thread->id) }}" enctype="multipart/form-data"
                        class="d-flex flex-column gap-4">
                        @csrf
                        @method('PUT')
                        <div>
                            <x-input-label for="title" :value="__('Заголовок')" />
                            <x-text-input id="title" class="block w-full mt-1" type="text" name="title"
                                :value="old('title', $thread->title)" required autofocus />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>
                        <div class="mt-4">
                            <x-input-label for="body" :value="__('Текст')" />
                            <x-text-area id="body" class="block w-full mt-1" name="body" :value="old('body', $thread->body)"
                                required />
                            <x-input-error :messages="$errors->get('body')" class="mt-2" />
                        </div>
                        <div class="mt-4">
                            <x-input-label for="image" :value="__('Загрузите изображение')" />
                            <x-file-input id="image" name="image" placeholder="Файл не выбран"
                                buttonText="Выберите изображение" accept="image/*" />
                            <x-input-error :messages="$errors->get('image')" class="mt-2" />
                        </div>
                        <div class="mt-4">
                            <x-input-label for="category_id" :value="__('Категория')" />
                            <select
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                id="category_id" name="category_id" required>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('category_id', $thread->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                        </div>


                        <div class="d-flex justify-content-end mt-4">
                            <x-primary-button>
                                {{ __('Изменить') }}
                            </x-primary-button>
                        </div>
                    </form>
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
