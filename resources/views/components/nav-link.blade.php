@props(['active' => false,'icon'])

<li class=" {{ $active
        ? 'bg-gray-500 group p-2 pr-5 rounded-md w-16.25 md:hover:w-40 overflow-hidden hover:rounded-xl transition-all duration-300 origin-left hover:bg-gray-800'
        : 'group p-2 pr-5 rounded-md w-16.25 md:hover:w-40 overflow-hidden hover:rounded-xl transition-all duration-300 origin-left hover:bg-gray-800' }}">
    <a {{ $attributes }} class=" flex items-center gap-3 ">
        <div class="icon p-2 py-1.5">
            <iconify-icon icon="{{ $icon }}" class="text-3xl"></iconify-icon>
        </div>
        <span class="text-lg ">{{ $slot }}</span>
    </a>
</li>
