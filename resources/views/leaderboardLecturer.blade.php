<x-app-layout>
  <div class="min-h-screen w-full bg-[#050e1a] text-gray-900">
    <!-- Sidebar (Fixed Left) -->
    <aside class="fixed top-0 left-0 h-screen w-64 text-white p-6 z-50 neon-sidebar">
            <div class="mb-8 flex items-start space-x-3">
                <img src="{{ asset('asset/logo.png') }}" alt="CQPP Logo" class="w-12 h-12">
                <span class="text-2xl font-bold">CQPP</span>
            </div>
            <nav class="space-y-4 mt-8">
                <a href="dashboard" class="flex items-center space-x-3 sidebar-link">
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('manage.notes') }}" class="flex items-center space-x-3 sidebar-link">
                    <span>Manage Learning Material</span>
                </a>
                <a href="{{ route('exercises.manage', $topic->id ?? 1) }}" class="flex items-center space-x-3 sidebar-link">
                    <span>Manage Exercise</span>
                </a>
                <a href="{{ route('leaderboard.lecturer') }}" class="flex items-center space-x-3 sidebar-link">
                    <span>Leaderboard</span>
                </a>
                <a href="report" class="flex items-center space-x-3 sidebar-link">
                    <span>Progress Report</span>
                </a>
            </nav>
        </aside>

    <!-- Top Header/Profile Bar -->
    <header class="fixed top-0 left-0 right-0 h-16 bg-[#071c2d] shadow flex justify-end items-center px-8 z-40">
      <div class="relative" x-data="{ open: false }">
        <button @click="open = !open" class="flex items-center space-x-2 text-gray-200 focus:outline-none">
          <span class="font-semibold">Shakirah</span>
          <svg class="w-4 h-4 transition-transform" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
          </svg>
        </button>
        <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-48 bg-white border rounded shadow-md divide-y divide-gray-200 z-50">
          <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
          <button class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Logout</button>
        </div>
      </div>
    </header>

    <!-- Main Content -->
    <main class="ml-50 pt-24 min-h-screen flex flex-col items-center">
      <!-- Interactive Leaderboard -->
      <div x-data='{
          search: "",
          sortKey: "rank",
          sortAsc: true,
          users: [ 
            { rank: 1, name: "Aina", avatar: "{{ asset('asset/A_Fiona.png') }}", topic1: 40, topic2: 39 },
            { rank: 2, name: "Anisha", avatar: "{{ asset('asset/A_BMO.png') }}", topic1: 38, topic2: 40 },
            { rank: 3, name: "Haziqah", avatar: "{{ asset('asset/A_Lady_Rainicorn.png') }}", topic1: 35, topic2: 37 },
            { rank: 4, name: "Amri", avatar: "{{ asset('asset/A_Jake.png') }}", topic1: 30, topic2: 35 },
            { rank: 5, name: "Qaisara", avatar: "{{ asset('asset/A_Tree_Trunks.png') }}", topic1: 30, topic2: 31 }
          ],
          opens: {}
        }' class="w-full max-w-4xl neon-frame p-6">
        <h2 class="text-3xl font-bold mb-4 text-[#15f7fc] text-center tracking-wider">CDCS2662A Leaderboard</h2>
        <!-- Search -->
        <div class="mb-4 text-right">
          <input type="text" x-model="search" placeholder="Search user..." class="px-3 py-1 rounded bg-[#061928] text-white focus:outline-none" />
        </div>
        <!-- Table -->
        <div class="overflow-x-auto">
          <table class="min-w-full text-center table-auto">
            <thead class="bg-[#071c2d]">
              <tr>
                <th @click="sortKey==='rank'? sortAsc=!sortAsc : (sortKey='rank',sortAsc=true)" class="py-3 px-4 text-[#15f7fc] text-base tracking-widest cursor-pointer">
                  Rank <span x-text="sortKey==='rank'? (sortAsc?'▲':'▼'): ''"></span>
                </th>
                <th @click="sortKey==='name'? sortAsc=!sortAsc : (sortKey='name',sortAsc=true)" class="py-3 px-4 text-[#15f7fc] text-base tracking-widest cursor-pointer">
                  Username <span x-text="sortKey==='name'? (sortAsc?'▲':'▼'): ''"></span>
                </th>
                <th @click="sortKey==='topic1'? sortAsc=!sortAsc : (sortKey='topic1',sortAsc=true)" class="py-3 px-4 text-[#15f7fc] text-base tracking-widest cursor-pointer">
                  Topic 1 <span x-text="sortKey==='topic1'? (sortAsc?'▲':'▼'): ''"></span>
                </th>
                <th @click="sortKey==='topic2'? sortAsc=!sortAsc : (sortKey='topic2',sortAsc=true)" class="py-3 px-4 text-[#15f7fc] text-base tracking-widest cursor-pointer">
                  Topic 2 <span x-text="sortKey==='topic2'? (sortAsc?'▲':'▼'): ''"></span>
                </th>
                <th @click="sortKey==='cumulative'? sortAsc=!sortAsc : (sortKey='cumulative',sortAsc=true)"
                    class="py-3 px-4 text-[#15f7fc] text-base tracking-widest cursor-pointer">
                  Cumulative <span x-text="sortKey==='cumulative'? (sortAsc?'▲':'▼'): ''"></span>
                </th>
              </tr>
            </thead>
            <tbody class="bg-[#061928cc]">
              <template x-for="user in users
                .map(u=>({ ...u, cumulative: u.topic1 + u.topic2 }))
                .filter(u=> u.name.toLowerCase().includes(search.toLowerCase()))
                .sort((a,b)=> {
                  let av = a[sortKey], bv = b[sortKey];
                  return sortAsc ? (av > bv?1: av < bv?-1:0) : (av < bv?1: av > bv?-1:0);
                })" :key="user.rank">
                <!-- Main Row -->
                <tr @click="opens[user.rank] = !opens[user.rank]" class="hover:bg-[#132946bb] transition cursor-pointer">
                  <td class="py-3 px-4 text-white font-bold">
                    <span x-text="user.rank <= 3 ? (['🥇','🥈','🥉'][user.rank-1]) : user.rank"></span>
                  </td>
                  <td class="flex items-center justify-center py-3 px-4 space-x-2">
                    <img :src="user.avatar" class="w-8 h-8 rounded-full border-2 border-[#15f7fc] shadow" :alt="user.name">
                    <span class="text-white font-semibold" x-text="user.name"></span>
                  </td>
                  <td class="py-3 px-4 text-[#15f7fc] font-bold" x-text="user.topic1"></td>
                  <td class="py-3 px-4 text-[#15f7fc] font-bold" x-text="user.topic2"></td>
                  <td class="py-3 px-4 text-[#15f7fc] font-bold" x-text="user.cumulative"></td>
                </tr>
                <!-- Detail Row -->
                <tr x-show="opens[user.rank]" class="bg-[#0f233d]">
                  <td colspan="5" class="text-left py-2 px-6">
                    <div class="space-y-2">
                      <div>
                        <span class="text-[#15f7fc] font-semibold">Topic 1:</span>
                        <div class="w-full bg-[#142946] rounded-full h-2 mt-1">
                          <div class="h-2 rounded-full" :style="`width:${(user.topic1/40)*100}%`" class="bg-[#15f7fc]"></div>
                        </div>
                        <span class="text-white text-sm ml-2" x-text="user.topic1 + ' / 40'"></span>
                      </div>
                      <div>
                        <span class="text-[#15f7fc] font-semibold">Topic 2:</span>
                        <div class="w-full bg-[#142946] rounded-full h-2 mt-1">
                          <div class="h-2 rounded-full" :style="`width:${(user.topic2/40)*100}%`" class="bg-[#15f7fc]"></div>
                        </div>
                        <span class="text-white text-sm ml-2" x-text="user.topic2 + ' / 40'"></span>
                      </div>
                    </div>
                  </td>
                </tr>
              </template>
            </tbody>
          </table>
        </div>
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
  </style>
</x-app-layout>
