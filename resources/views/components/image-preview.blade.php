<div x-data="{ modalOpen: false, imageUrl: '', imageInfo: null }" class="inline-block" @keydown.escape.window="modalOpen = false">
    @if ($imagePath)
        <img src="{{ asset($imagePath) }}" alt="Изображение" style="max-width: {{ $maxWidth }}; cursor: pointer;"
            @click="modalOpen = true; imageUrl = $el.src; fetchImageInfo()" class="rounded-lg">
    @endif

    <div x-show="modalOpen" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
        style="display: none;" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click.self="modalOpen = false">
        <div class="relative bg-white rounded-lg shadow-xl border border-gray-200 overflow-hidden"
            style="width: 80dvw; height: 90dvh;">
            <button type="button" @click="modalOpen = false"
                class="position-absolute top-6 start-6 text-gray-500 hover:text-gray-700 focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
            <div class="flex items-center justify-center h-full">
                @if ($imagePath)
                    <img :src="imageUrl" alt="Полное изображение" class="object-fit rounded-lg"
                        style="max-width: 75dvw; max-height: 80dvh;" />
                @endif
            </div>
        </div>
    </div>
</div>
