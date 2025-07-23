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
    
<script>
document.addEventListener('alpine:init', () => {
  Alpine.data('progressMap', () => ({
    percentages: [],
    pathEl: null,
    totalLen: 0,
    currentIndex: 0,
    jumping: false,

    init(pcts) {
      this.percentages  = pcts;
      this.pathEl       = this.$refs.orbitPath;
      this.totalLen     = this.pathEl.getTotalLength();

      // position on last completed
      let idx = this.percentages.findIndex(p => p < 100);
      this.currentIndex = (idx === -1 ? this.percentages.length - 1 : Math.max(0, idx - 1));
    },

    planetStyle(i) {
      const t  = i / ((this.percentages.length - 1) || 1);
      const pt = this.pathEl.getPointAtLength(t * this.totalLen);
      return { left: `${pt.x - 16}px`, top: `${pt.y - 16}px` };
    },

    astronautStyle() {
      const t  = this.currentIndex / ((this.percentages.length - 1) || 1);
      const pt = this.pathEl.getPointAtLength(t * this.totalLen);
      return { left: `${pt.x - 24}px`, top: `${pt.y - 36}px` };
    },

    jumpTo(idx) {
      this.currentIndex = idx;
      this.jumping = true;
      setTimeout(() => this.jumping = false, 700);
    },
  }));
});
</script>


</body>
</html>
