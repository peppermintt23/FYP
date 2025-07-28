<x-app-layout>
<div class="flex min-h-screen w-full bg-[#050e1a]">
    <!-- Sidebar -->
        <aside class="fixed top-0 left-0 h-screen w-64 text-white p-6 z-50 neon-sidebar">
            <div class="mb-8 flex items-center space-x-3">
                <img src="{{ asset('asset/logo.png') }}" alt="CQPP Logo" class="w-12 h-12">
                <span class="text-2xl font-bold">CQPP</span>
            </div>
            <nav class="space-y-4 mt-8">
                <a href="#" class="flex items-center space-x-3 sidebar-link">
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

    <!-- Main area -->
    <div class="flex-1 flex flex-col min-h-screen ml-60">
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

        <!-- Main Content -->
        <main class="pt-24 min-h-screen flex flex-col pl-6 pr-4">

            <form method="GET" class="mb-8 flex gap-4">
                <select name="groupCourse" class="neon-input" onchange="this.form.submit()">
                    <option value="">Select Class</option>
                    @foreach($classes as $cls)
                        <option value="{{ $cls->groupCourse }}" {{ $selectedGroup==$cls->groupCourse?'selected':'' }}>
                            {{ $cls->groupCourse }}
                        </option>
                    @endforeach
                </select>
                <select name="topic" class="neon-input" onchange="this.form.submit()">
                    <option value="">Select Topic</option>
                    @foreach($topics as $tp)
                        <option value="{{ $tp->id }}" {{ $selectedTopicId==$tp->id?'selected':'' }}>
                            {{ $tp->topic_title }}
                        </option>
                    @endforeach
                </select>
            </form>

            @if($selectedGroup && $selectedTopicId && count($progressData))
                <div class="bg-[#101b2a] neon-frame p-8 mb-12 max-w-3xl">
                    <h2 class="font-bold text-2xl mb-8 text-cyan-300">
                        Student Progress for: <span class="text-[#7dfcfc]">{{ $selectedGroup }}</span>
                    </h2>
                    <canvas id="studentProgressChart" height="300"></canvas>
                </div>
            @elseif($selectedGroup && $selectedTopicId)
                <div class="text-cyan-300 mt-8">No student or progress found.</div>
            @else
                <div class="text-cyan-300 mt-8">Please select a class and topic.</div>
            @endif
            
        </main>

    </div>
</div> 


@if($selectedGroup && $selectedTopicId && count($progressData))

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const students = @json(array_column($progressData, 'student_name')); 
const exercises = @json($exercises->pluck('exercise_title')); 
const progressData = @json(array_column($progressData, 'statuses')); 

const exerciseColors = [
    "rgba(67, 123, 244, 0.85)",   // Blue
    "rgba(174, 80, 255, 0.85)",   // Purple
    "rgba(249, 97, 179, 0.85)",   // Pink
    "rgba(0, 235, 180, 0.85)",    // Teal
    "rgba(255, 195, 90, 0.85)",   // Orange
    "rgba(98, 220, 255, 0.85)",   // Cyan
    "rgba(255, 91, 91, 0.85)",    // Red
];

const statusColors = [
    'rgba(90,90,100,0.13)',        
    null,                          
    null,
    null
];


const datasets = exercises.map((exercise, eIdx) => {
    return {
        label: exercise,
        data: progressData.map(stuStatuses => stuStatuses[eIdx] > 0 ? stuStatuses[eIdx] : 0), 
        backgroundColor: exerciseColors[eIdx % exerciseColors.length],
        borderWidth: 2,
        borderColor: '#101b2a',
        borderRadius: 12,
        maxBarThickness: 34,
    }
});

const ctx = document.getElementById('studentProgressChart').getContext('2d');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: students,
        datasets: datasets
    },
    options: {
        indexAxis: 'y',
        responsive: true,
        plugins: {
            legend: {
                display: true,
                position: 'top',
                labels: {
                    color: '#a9fcff',
                    font: { size: 16, weight: 'bold' },
                }
            },
            tooltip: {
                callbacks: {
                    label: function(ctx) {
                        let v = ctx.raw;
                        if(v === 1) return `${ctx.dataset.label}: Completed Guideline`;
                        if(v === 2) return `${ctx.dataset.label}: Completed - Pending Feedback`;
                        if(v === 3) return `${ctx.dataset.label}: Completed - Submitted Feedback`;
                        return `${ctx.dataset.label}: Not started`;
                    }
                }
            }
        },
        scales: {
            x: {
                beginAtZero: true,
                min: 0,
                max: 3,
                ticks: {
                    color: '#c9fbff',
                    stepSize: 1,
                    callback: function(val) {
                        if(val==1) return 'Guideline';
                        if(val==2) return 'Pending';
                        if(val==3) return 'Feedback';
                        return '';
                    }
                },
                grid: { color: '#1be1ff22' }
            },
            y: {
                ticks: {
                    color: '#c9fbff',
                    font: { size: 16, weight: 'bold' }
                },
                grid: { color: '#1be1ff22' }
            }
        }
    }
});
</script>
@endif


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
    aside.fixed .text-2xl {
            color: #13e2be !important;
            text-shadow: 0 0 8px #13e2be77;
        }
    .neon-frame span,
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
</style>
</x-app-layout>