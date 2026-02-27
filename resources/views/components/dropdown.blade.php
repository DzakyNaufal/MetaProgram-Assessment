@props(['align' => 'right', 'width' => '48', 'contentClasses' => 'py-1 bg-white'])

@php
$width = match ($width) {
    '48' => 'w-48',
    default => $width,
};
@endphp

<div x-data="{
    open: false,
    dropdownStyle: '',
    toggleDropdown() {
        this.open = !this.open;
        if (this.open) {
            this.$nextTick(() => {
                const trigger = this.$refs.trigger.getBoundingClientRect();
                this.dropdownStyle = `position: fixed; z-index: 99999; top: ${trigger.bottom + 8}px; right: ${window.innerWidth - trigger.right}px;`;
            });
        }
    }
}" @click.outside="open = false" @close.stop="open = false" x-cloak>
    <div @click="toggleDropdown()" x-ref="trigger">
        {{ $trigger }}
    </div>

    <div x-show="open"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-75"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="{{ $width }} rounded-md shadow-lg"
            :style="dropdownStyle"
            x-ref="dropdown"
            style="display: none;"
            @click="open = false">
        <div class="rounded-md ring-1 ring-black ring-opacity-5 {{ $contentClasses }}">
            {{ $content }}
        </div>
    </div>
</div>
