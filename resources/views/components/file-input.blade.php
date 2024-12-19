@props([
    'name' => 'file',
    'accept' => 'image/*',
    'placeholder' => 'Файл не выбран',
    'buttonText' => 'Выбрать файл',
    'labelClass' =>
        'btn btn-outline-primary rounded-lg px-6 py-2 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm',
    'inputClass' =>
        'form-control bg-white text-black rounded-lg border border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 focus:ring-1 p-2',
    'icon' => 'fas fa-upload',
])

<div x-data="{ fileName: '{{ $placeholder }}' }" class="flex items-center gap-6 flex-col sm:flex-row">
    <input type="file" id="{{ $name }}" name="{{ $name }}" accept="{{ $accept }}"
        @change="fileName = $event.target.files[0] ? $event.target.files[0].name : '{{ $placeholder }}'"
        class="hidden" />
    <label for="{{ $name }}" class="{{ $labelClass }} cursor-pointer flex items-center gap-2">
        <i class="{{ $icon }} mr-2 text-xl" aria-hidden="true"></i>
        {{ $buttonText }}
    </label>
    <input type="text" class="{{ $inputClass }} w-64" x-model="fileName" disabled />
</div>
