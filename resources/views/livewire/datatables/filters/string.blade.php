<div x-data class="flex flex-col">
    <input
        x-ref="input"
        placeholder="{{ $name }}"
        type="text"
        class="p-3 m-6 text-sm leading-4 flex-grow form-input w-80"
        wire:change="doTextFilter('{{ $name }}', $event.target.value)"
        x-on:change="$refs.input.value = ''"
        style="border: 1px solid #E4E6EF !important;border-radius: 0.675rem !important;"
    />
    <div class="flex flex-wrap max-w-48 space-x-1">
        @foreach($this->activeTextFilters[$index] ?? [] as $key => $value)
            <button wire:click="removeTextFilter('{{ $index }}', '{{ $key }}')" class="m-1 pl-1 flex items-center uppercase tracking-wide bg-gray-300 text-white hover:bg-red-600 rounded-full focus:outline-none text-xs space-x-1">
                <span>{{ $this->getDisplayValue($index, $value) }}</span>
                <x-icons.x-circle />
            </button>
        @endforeach
    </div>
</div>
