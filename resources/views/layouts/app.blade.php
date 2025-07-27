<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        

        <div class="min-h-screen flex">

            <!-- Main Content -->
            <main class="ml-64 flex-1 p-8">
                {{ $slot }}
            </main>

        </div>

         <!-- Add this script to ensure redirection if user is logged out -->
        <script>
            if (!{{ Auth::check() ? 'true' : 'false' }}) {
                window.location.href = "{{ route('login') }}"; // Redirect to login if user is not authenticated
            }
        </script>

    <!-- Progress‐map component logic -->
    <script src="//unpkg.com/alpinejs" defer></script>
<script>
function progressMap(pcts = [], idx = 0) {
    return {
        percentages: Array.isArray(pcts) ? pcts.map(Number) : [],
        activeIdx: typeof idx === 'number' ? idx : 0,
        positions: [],
        jumping: false,
        init() {
            this.$nextTick(() => {
                const path = this.$refs.orbitPath;
                if (!path) return;
                const len = path.getTotalLength();
                // Single topic: center
                if (this.percentages.length === 1) {
                    const svgPt = path.getPointAtLength(len * 0.5);
                    this.positions = [{ left: svgPt.x, top: svgPt.y }];
                } else {
                    this.positions = this.percentages.map((_, i, arr) => {
                        const pct = arr.length > 1 ? i / (arr.length - 1) : 0;
                        const svgPt = path.getPointAtLength(len * pct);
                        return { left: svgPt.x, top: svgPt.y };
                    });
                }
                this.doJump();
            });
        },
        planetStyle(idx) {
            if (!this.positions[idx]) return '';
            return `left:${this.positions[idx].left - 24}px;top:${this.positions[idx].top - 24}px;z-index:20;`;
        },
        astronautStyle() {
            if (!this.positions[this.activeIdx]) return '';
            return `left:${this.positions[this.activeIdx].left - 24}px;top:${this.positions[this.activeIdx].top - 56}px;z-index:30;`;
        },
        doJump() {
            this.jumping = false;
            this.$nextTick(() => {
                this.jumping = true;
                setTimeout(() => { this.jumping = false; }, 700);
            });
        }
    }
}
</script>


</body>
</html>
