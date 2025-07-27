<x-app-layout>
  <div class="min-h-screen w-full bg-[#050e1a] text-white" x-data="{ view: 'classes' }">
    <!-- Sidebar (Fixed Left) -->
    <aside class="fixed top-0 left-0 h-screen w-64 text-white p-6 z-50 neon-sidebar">
      <div class="mb-8 flex items-center space-x-3">
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
        <a href="#" 
           @click.prevent="view='classes'" 
           :class="view==='classes' ? 'active' : ''"
           class="flex items-center space-x-3 sidebar-link">
          <span>Progress Report</span>
        </a>
      </nav>
    </aside>

    <!-- Top Header/Profile Bar -->
    <header class="fixed top-0 left-0 right-0 h-16 bg-[#071c2d] shadow flex justify-end items-center px-8 z-40">
      <div class="relative" x-data="{ open: false }">
        <button @click="open = !open" class="flex items-center space-x-2 text-gray-200 focus:outline-none">
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

    <!-- Main Content -->
    <main class="ml-64 pt-24 px-8 min-h-screen flex flex-col items-center">
      <div class="w-full max-w-5xl neon-frame p-8 mx-auto mt-10">
        <h2 class="text-3xl font-bold text-[#15f7fc] mb-8 text-center tracking-wide">STUDENTS PROGRESS REPORT</h2>

        {{-- CLASS Table --}}
        <div class="overflow-x-auto mb-12">
  <table class="min-w-full text-center border-separate border-spacing-y-3">
    <thead>
      <tr class="bg-[#0a132a] text-[#15f7fc] text-base">
        <th class="py-2 px-4 border-b-2 border-[#15f7fc] font-semibold text-lg text-left">Class</th>
        @foreach($topics as $topic)
          <th class="py-2 px-4 border-b-2 border-[#15f7fc] font-semibold text-lg">
            Avg Score<br><span class="font-normal">{{ $topic->topic_title }}</span> (%)
          </th>
        @endforeach
        <th class="py-2 px-4 border-b-2 border-[#15f7fc] font-semibold text-lg">Students Passed</th>
      </tr>
    </thead>
    <tbody class="text-white">
      @foreach($classes as $class)
        <tr class="hover:bg-[#132946] transition">
          <td class="py-2 px-4 text-left font-medium">{{ $class }}</td>
          @foreach($topics as $topic)
            <td class="py-2 px-4">{{ $summary[$class]['topics'][$topic->id] ?? '-' }}</td>
          @endforeach
          <td class="py-2 px-4">
            {{ $summary[$class]['students_passed'] ?? 0 }}/{{ $summary[$class]['students_count'] ?? 0 }}
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>
        <hr class="border-white mb-8">

        {{-- TOPIC Table --}}
        <div class="overflow-x-auto">
  <table class="min-w-full text-center border-separate border-spacing-y-3">
    <thead>
      <tr class="bg-[#0a132a] text-[#15f7fc] text-base">
        <th class="py-2 px-4 border-b-2 border-[#15f7fc] font-semibold text-lg text-left">Topic</th>
        @foreach($classes as $class)
          <th class="py-2 px-4 border-b-2 border-[#15f7fc] font-semibold text-lg">
            {{ $class }}<br><span class="font-normal">Attempt/Total</span>
          </th>
        @endforeach
        <th class="py-2 px-4 border-b-2 border-[#15f7fc] font-semibold text-lg">Avg Score (%)</th>
      </tr>
    </thead>
    <tbody class="text-white">
      @foreach($detailed as $row)
        <tr class="hover:bg-[#132946] transition">
          <td class="py-2 px-4 text-left font-medium">{{ $row['topic'] }}</td>
          @foreach($classes as $class)
            <td class="py-2 px-4">
              <div class="font-semibold">{{ $row[$class]['attempt_string'] ?? '-' }}</div>
              <div class="text-sm text-[#15f7fc]">{{ $row[$class]['avg'] ?? '-' }}%</div>
            </td>
          @endforeach
          <td class="py-2 px-4 font-semibold">{{ $row['avg_score'] }}%</td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>
      </div>
    </main>
  </div>
</x-app-layout>

{{-- Styles (reuse your neon classes) --}}
<style>
  .neon-frame {
    background: rgba(10, 18, 36, 0.98);
    border: 3px solid #15f7fc;
    border-radius: 2px;
    box-shadow:
      0 0 18px 3px #15f7fc,
      0 0 38px 1px #15f7fc44 inset,
      0 0 0 7px #061928;
    position: relative;
    overflow: hidden;
  }
  .neon-inner {
    box-shadow: 0 0 16px #15f7fc33 inset;
  }
  .neon-sidebar {
    background: #0a132a;
    border-right: 3.5px solid #13e2be;
    box-shadow: 0 0 12px #13e2be44, 0 4px 24px #0a243155;
  }
  aside.fixed .text-2xl {
            color: #13e2be !important;
            text-shadow: 0 0 8px #13e2be77;
        }
  .neon-frame span,
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
  .sidebar-link:hover,
  .sidebar-link.active {
    background: #142755bb;
    border-color: #15f7fc;
    color: #15f7fc;
    box-shadow: 0 0 10px #15f7fc44;
  }
  body, .min-h-screen {
    background: #050e1a;
  }
</style>
