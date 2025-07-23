{{-- resources/views/components/progress-map.blade.php --}}
@props([
    'percentages',
    'bgImage'   => asset('images/bg.png'),
    'iconImage' => asset('images/A_Fiona.png'),
])

<div
    x-data="progressMap()"
    x-init="init(@json($percentages))"
    class="relative w-full h-64 overflow-hidden rounded-2xl"
    style="background: url('{{ $bgImage }}') center/cover no-repeat;"
>
    {{-- Dim overlay --}}
    <div class="absolute inset-0 bg-black opacity-30"></div>

    {{-- Invisible SVG curve for layout --}}
    <svg viewBox="0 0 800 200" class="absolute inset-0 w-full h-full">
        <path
            x-ref="orbitPath"
            d="M50,150 C200,20 600,20 750,150"
            fill="none"
            stroke="transparent"
            stroke-width="2"
        />
    </svg>

    {{-- Planets showing each percentage, clickable to jump --}}
    <template x-for="(pct, idx) in percentages" :key="idx">
        <div
            @click="jumpTo(idx)"
            class="absolute w-8 h-8 rounded-full bg-gradient-to-br from-blue-400 to-teal-300 \
                   shadow-lg flex items-center justify-center text-xs text-white font-bold cursor-pointer"
            :style="planetStyle(idx)"
            x-text="`${pct}%`"
        ></div>
    </template>

    {{-- Avatar/rocket icon --}}
    <img
        src="{{ $iconImage }}"
        alt="You are here"
        class="absolute w-12 transition-all duration-700 ease-out"
        :style="astronautStyle()"
    />
</div>
