<x-app-layout>
  @if(!isset($groupCourse))
    <div class="text-center text-red-500 py-8 text-xl">Please select a class from the Leaderboard menu.</div>
    @php return; @endphp
@endif

  <div class="min-h-screen w-full bg-[#050e1a] text-gray-900">
    <!-- Sidebar (Fixed Left) -->
    <aside class="fixed top-0 left-0 h-screen w-64 text-white p-6 z-50 neon-sidebar">
            <div class="mb-8 flex items-start space-x-3">
                <img src="{{ asset('asset/logo.png') }}" alt="CQPP Logo" class="w-12 h-12">
                <span class="text-2xl font-bold">CQPP</span>
            </div>
            <nav class="space-y-4 mt-8">
                <a href="{{ route('lecturer.dashboard') }}" class="flex items-center space-x-3 sidebar-link">
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('manage.notes') }}" class="flex items-center space-x-3 sidebar-link">
                    <span>Manage Learning Material</span>
                </a>
                <a href="{{ route('exercises.manage', $topic->id ?? 1) }}" class="flex items-center space-x-3 sidebar-link">
                    <span>Manage Exercise</span>
                </a>
                
                <a href="{{ route('viewReport') }}" class="flex items-center space-x-3 sidebar-link">
                    <span>Progress Report</span>
                </a>
            </nav>
        </aside>

        <!-- Top Header/Profile Bar -->
        <header class="fixed top-0 left-0 right-0 h-16 bg-[#071c2d] shadow flex justify-end items-center px-8 z-40">
          <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" class="flex items-center space-x-2 text-cyan-200 focus:outline-none">
                    <span class="font-semibold">{{ Auth::user()->name }}</span>
                    <svg class="w-4 h-4 transition-transform" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div x-show="open" @click.away="open = false" x-transition
                    class="absolute right-0 mt-2 w-48 bg-[#0f172a] border border-cyan-400 rounded shadow-md divide-y divide-gray-200 z-50">
                    <div class="py-1">
                        <a href="{{ url('/lecturer/profile/') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            Profile
                        </a>
                    </div>
                    <div class="py-1">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="block w-full text-left px-4 py-2 text-sm text-cyan-200 hover:bg-cyan-900 hover:text-white">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <main class="ml-64 pt-24 min-h-screen flex flex-col items-center"
            x-data="{
              students: @js($students),
              topics: @js($topics),
              loading: false,
              fetchLeaderboard() {
                this.loading = true;
                fetch('{{ route('leaderboard.lecturer', ['groupCourse' => $groupCourse]) }}?json=1')
                  .then(res => res.json())
                  .then(data => {
                      this.students = data.students;
                      this.topics = data.topics;
                      this.loading = false;
                  });
              },
              init() {
                setInterval(() => this.fetchLeaderboard(), 5000); // refresh every 5s
              }
            }"
            x-init="init()"
      >
        <div class="w-full max-w-5xl neon-frame p-8">
          <h2 class="text-3xl font-bold mb-8 text-[#15f7fc] text-center tracking-wider">{{ $groupCourse }} Leaderboard</h2>

          <!-- Table Leaderboard -->
          <div class="overflow-x-auto">
            <table class="min-w-full text-center table-auto mt-4">
              <thead>
                  <tr>
                      <th>Rank</th>
                      <th></th>
                      <th>Username</th>
                      <th>Time</th>
                      @foreach($topics as $topic)
                          <th>{{ $topic->topic_title }}</th>
                      @endforeach
                      <th>Total</th>
                  </tr>
              </thead>
              <tbody>
                  @foreach($students as $student)
                      <tr>
                          <td>{{ $student['rank'] }}</td>
                          <td><img src="{{ $student['avatar'] }}" class="w-10 h-10 rounded-full" /></td>
                          <td>{{ $student['name'] }}</td>
                          <td>{{ $student['time'] }}</td>
                          @foreach($topics as $topic)
                              <td>
                                  {{ $student['topicScores'][$topic->id] !== null ? $student['topicScores'][$topic->id] : '-' }}
                              </td>
                          @endforeach
                          <td>{{ $student['totalPoints'] }}</td>
                      </tr>
                  @endforeach
              </tbody>

            </table>
          </div>

          <div x-show="loading" class="absolute left-0 right-0 text-center py-2 text-[#15f7fc] animate-pulse">Updating...</div>
        </div>
      </main>


  </div>

  <style>
    
    html, body { background: #050e1a !important; min-height: 100vh; width: 100vw;}
    .progress-bar-outer {
        background: repeating-linear-gradient(
            45deg, #22313e 0 16px, #16202a 16px 32px
        );
        border: 2px solid #2ae9f6;
        border-radius: 24px;
        box-shadow: 0 0 10px #14e1ee55;
        height: 40px;
        position: relative;
        overflow: hidden;
        margin-bottom: 6px;
    }
    .progress-bar-inner {
        height: 100%;
        border-radius: 24px;
        color: #0fe9fa;
        display: flex;
        align-items: center;
        font-weight: bold;
        font-size: 1.2em;
        padding-left: 20px;
        /* Add animation! */
        background-size: 200% 100%;
        transition: width 1.2s cubic-bezier(.4,2.2,.2,1);
        position: relative;
        min-width: 44px;
    }
    .progress-label {
        text-shadow: 0 2px 10px #13e2be99;
    }
    .progress-bar-inner.moving {
        animation: movingbg 3s linear infinite;
    }
    @keyframes movingbg {
        from { background-position-x: 0; }
        to   { background-position-x: 200px; }
    }
    .neon-frame {
        background: rgba(10, 10, 30, 0.97);
        border: 3px solid #15f7fc;
        border-radius: 22px;
        box-shadow: 0 0 24px 5px #15f7fc, 0 0 44px 1px #00bfff85 inset, 0 0 0 9px #061928;
        position: relative;
        overflow: hidden;
    }
    .neon-sidebar {
        background: #0a132a;
        border-right: 3.5px solid #13e2be;
        box-shadow: 0 0 12px #13e2be44, 0 4px 24px #0a243155;
    }
    .sidebar-link {
        background: transparent;
        border: 2px solid transparent;
        border-radius: 2px;
        color: #c9fbff;
        font-weight: 500;
        transition: all 0.18s;
        letter-spacing: 1.2px;
        padding: 0.75rem 1.2rem;
        display: flex;
        align-items: center;
    }
    .sidebar-link:hover, .sidebar-link.active {
        background: #142755bb;
        border-color: #15f7fc;
        color: #15f7fc;
        box-shadow: 0 0 10px #15f7fc44;
    }
    .neon-input {
        border: 1.5px solid #15f7fc;
        background: #071c2d;
        color: #c9fbff;
        border-radius: 8px;
        padding: 0.7rem 1.2rem;
        outline: none;
        font-size: 1.1rem;
    }
    .neon-input:focus {
        border: 2px solid #14e1ee;
        background: #0a132a;
        color: #00fff3;
        box-shadow: 0 0 12px #19ffe799;
    }


    /* existing styles unchanged */
    .neon-frame { background: rgba(10,18,36,0.98); border:3px solid #15f7fc; border-radius:2px;
      box-shadow:0 0 18px 3px #15f7fc,0 0 38px 1px #15f7fc44 inset,0 0 0 7px #061928; position: relative; overflow:hidden; }
    .neon-frame:before { content:''; position:absolute; inset:0; border-radius:inherit; border:2px solid #19ffe7;
      filter:blur(3px); opacity:0.22; pointer-events:none; }
    .neon-inner { box-shadow: 0 0 16px #15f7fc33 inset; }
    aside.fixed { background: linear-gradient(160deg,#0a132a 70%,#14e1ee3c 100%); border-right:3.5px solid #13e2be;
      box-shadow:0 0 12px #13e2be44,0 4px 24px #0a243155; }
    aside.fixed .text-2xl { color:#13e2be!important; text-shadow:0 0 8px #13e2be77; }
    aside.fixed nav a { background:transparent; border:2px solid transparent; border-radius:2px;
      color:#c9fbff; font-weight:500; transition:all .18s; letter-spacing:1.2px; }
    aside.fixed nav a:hover, aside.fixed nav a.active { background:#142755bb;
      border-color:#15f7fc; color:#15f7fc; box-shadow:0 0 10px #15f7fc44; }
    header.fixed { background:#071c2d; box-shadow:0 1px 10px #14e1ee33; color:#13e2be; }
    header .font-semibold { color:#15f7fc; text-shadow:0 0 6px #15f7fcaa; }
    body, .min-h-screen { background:#050e1a; }

    .neon-frame table th, 
    .neon-frame table td {
        color: #15f7fc !important;   /* Neon cyan */
        font-weight: 500;
        text-shadow: 0 1px 8px #0fffc7aa;
    }

    .neon-frame table td {
        font-weight: 400;
    }

    .neon-frame table tr {
        transition: background 0.2s;
    }

    .neon-frame table tr:hover {
        background: #122d39; /* subtle highlight on hover */
    }

    .podium-row {
      gap: 2.5rem;
    }
    .podium-card {
      background: rgba(10,20,40,0.88);
      border: 2.5px solid #15f7fc;
      border-radius: 22px;
      padding: 38px 28px 20px 28px;
      min-width: 168px;
      box-shadow: 0 2px 28px 6px #15f7fc88, 0 0 16px #19ffe744 inset;
      margin-top: 36px;
      position: relative;
      transition: transform 0.18s;
      text-align: center;
    }
    .podium-card.first { transform: translateY(-44px) scale(1.1); z-index:2; border-color: #ffd700; box-shadow: 0 2px 40px 12px #ffd70055, 0 0 30px #15f7fc99 inset; }
    .podium-card.second { transform: translateY(-10px) scale(1.02); border-color: #9da9ff; }
    .podium-card.third { transform: translateY(8px) scale(1); border-color: #cd7f32; }
    .podium-medal {
      top: -32px;
      left: 50%;
      transform: translateX(-50%);
      font-weight: bold;
      font-size: 1.25rem;
      filter: drop-shadow(0 2px 16px #000a);
    }
    .avatar-podium { box-shadow: 0 2px 18px #0fffc766; background: #092634; }

    .neon-frame table th, .neon-frame table td {
      color: #15f7fc !important;   
      font-weight: 500;
      text-shadow: 0 1px 8px #0fffc7aa;
    }
    .neon-frame table td { font-weight: 400; }
    .neon-frame table tr { transition: background 0.2s; }
    .neon-frame table tr:hover { background: #122d39; }
    .neon-frame table th { font-size: 1.1em; }


  </style>
</x-app-layout>
