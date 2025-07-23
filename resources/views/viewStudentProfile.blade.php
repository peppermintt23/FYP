<x-app-layout>
<div class="min-h-screen w-full bg-[#050e1a] text-gray-900">
    <!-- Sidebar (Fixed Left) -->
    <aside class="fixed top-0 left-0 h-screen w-64 text-white p-6 z-50">
            <div class="mb-8 flex items-center space-x-3">
                <img src="{{ asset('asset/logo.png') }}" alt="CQPP Logo" class="w-8 h-8">
                <span class="text-2xl font-bold">CQPP</span>
            </div>
            <nav class="space-y-4 mt-8">
                <a href="dashboard" class="flex items-center space-x-3 hover:bg-[#142755bb] p-2 rounded">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9.75L12 4l9 5.75M4.5 10.5V19a1.5 1.5 0 001.5 1.5h12a1.5 1.5 0 001.5-1.5v-8.5" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 22V12h6v10" />
                    </svg>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('notes.index') }}" class="flex items-center space-x-3 hover:bg-[#142755bb] p-2 rounded">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <rect x="3" y="4" width="7" height="16" rx="2" ry="2" stroke-width="2" stroke="currentColor" fill="none"/>
                        <rect x="14" y="4" width="7" height="16" rx="2" ry="2" stroke-width="2" stroke="currentColor" fill="none"/>
                    </svg>
                    <span>Notes</span>
                </a>
                <a href="{{ route('answer.index') }}" class="flex items-center space-x-3 hover:bg-[#142755bb] p-2 rounded">
                     <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <rect width="16" height="20" x="4" y="2" rx="2" ry="2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></rect>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 6h6" />
                    </svg>
                    <span>Exercise</span>
                </a>
                <!-- Leaderboard Dropdown Start -->
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" type="button"
                        class="flex items-center w-full space-x-3 hover:bg-[#142755bb] p-2 rounded focus:outline-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 21h8m-4-4v4m-7-9a7 7 0 0014 0V4H5v4z" />
                        </svg>
                        <span>Leaderboard</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open" @click.away="open = false"
                        class="absolute left-0 mt-1 w-48 bg-gray rounded shadow-lg z-30"
                        x-transition>
                        <a href="{{ url('/student/leaderboard/personal') }}"
                        class="block px-4 py-2 text-gray-800 hover:bg-[#f0ecff] rounded-t">
                            Personal Leaderboard
                        </a>
                        <a href="{{ url('/student/leaderboard/overall') }}"
                        class="block px-4 py-2 text-gray-800 hover:bg-[#f0ecff] rounded-b">
                            Overall Leaderboard
                        </a>
                    </div>

                </div>
                <!-- Leaderboard Dropdown End -->
            </nav>
    </aside>

    <!-- Top Header/Profile Bar -->
    <header class="fixed top-0 left-0 right-0 h-16 bg-[#071c2d] shadow flex justify-end items-center px-8 z-40">
        <div class="relative" x-data="{ open: false }">
            <button @click="open = !open" class="flex items-center space-x-2 text-gray-200 focus:outline-none">
                <span class="font-semibold">{{ Auth::user()->name ?? 'Username' }}</span>
                <svg class="w-4 h-4 transition-transform" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
            <div x-show="open" @click.away="open = false" x-transition
                 class="absolute right-0 mt-2 w-48 bg-white border rounded shadow-md divide-y divide-gray-200 z-50">
                <div class="py-1">
                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        Profile
                    </a>
                </div>
                <div class="py-1">
                    <form method="POST" action="#">
                        @csrf
                        <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="ml-70 mt-5 p-8 min-h-screen bg-transparent flex flex-col items-center">
        <div 
            class="w-full max-w-2xl neon-frame p-8 mt-4 mx-auto"
            x-data='{
            showPicker: false,
            selected: @json(old("avatar", $user->avatar) ?? ""),
            avatars: @json($avatars)
        }'
        >

            <form method="POST" action="{{ route('profile.update') }}">
            @csrf
            @method('PUT')

            {{-- Profile Info --}}
            <div class="flex flex-col md:flex-row items-center gap-8 mb-8">

                {{-- **Replace your old Avatar Preview block with this:** --}}
                <div class="flex items-center gap-4">
                <!-- live preview -->
                <img
                    :src=" selected 
                            ? `{{ asset('asset/avatars') }}/${selected}` 
                            : `{{ asset('asset/avatars/default-avatar.png') }}`"
                    alt="Avatar"
                    class="w-20 h-20 rounded-full border-2"
                >
                <!-- button to open picker -->
                <button type="button"
                        @click="showPicker = true"
                        class="edit-btn">
                    Choose Avatar
                </button>
                </div>

                {{-- **Hidden field carries the filename** --}}
                <input type="hidden" name="avatar" x-model="selected">

                {{-- then your Name & Student Number fields as before... --}}
                <div class="flex-1 flex flex-col items-center md:items-start">
                <!-- name input -->
                <label class="block text-white mb-1">Name</label>
                    <input
                        type="text"
                        name="name"
                        value="{{ old('name',$user->name) }}"
                        class="w-full p-2 rounded mb-2"
                    >
                    @error('name')<div class="text-red-500 text-sm">{{ $message }}</div>@enderror

                <!-- student_number input -->
                <label class="block text-white mb-1">Student Number</label>
                    <input
                        type="text"
                        name="student_number"
                        value="{{ old('student_number',$user->student_number) }}"
                        class="w-full p-2 rounded mb-4"
                    >
                    @error('student_number')<div class="text-red-500 text-sm">{{ $message }}</div>@enderror

                <button type="submit" class="edit-btn mt-4">Save Profile</button>
                </div>
            </div>
            </form>

             {{-- **Immediately after the closing </form>, paste your modal:** --}}
            <div
            x-show="showPicker"
            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center"
            >
            <div class="bg-white rounded-lg p-6 w-11/12 max-w-md">
                <h2 class="text-xl font-semibold mb-4">Select an Avatar</h2>
                <div class="grid grid-cols-4 gap-4">
                <template x-for="av in avatars" :key="av">
                    <div
                    class="cursor-pointer border-2 rounded overflow-hidden"
                    :class="selected === av ? 'border-blue-500' : 'border-transparent'"
                    @click="selected = av"
                    >
                    <img :src="`{{ asset('asset/avatars') }}/${av}`" class="w-full h-auto">
                    </div>
                </template>
                </div>
                <div class="mt-6 flex justify-end gap-2">
                <button @click="showPicker = false" type="button" class="px-4 py-2 rounded bg-gray-200">
                    Cancel
                </button>
                <button @click="showPicker = false" type="button" class="px-4 py-2 rounded bg-blue-600 text-white">
                    Select
                </button>
                </div>
            </div>
            </div>

           <!-- COMPLETION -->
            <div class="text-lg font-bold text-[#13e2be] mb-3">EXERCISE COMPLETION</div>
            <div class="progress-table bg-[#101b2a] border-2 border-[#15f7fc66] rounded-xl shadow p-5 mb-6 max-h-[480px] overflow-y-auto custom-scroll-vert">

            @foreach($topics as $topic)
                <div class="progress-topic-card bg-[#152440cc] border border-[#15f7fc44] rounded-xl p-4 mb-5 neon-card">
                <div class="topic-title text-[#15f7fc] font-bold mb-1">
                    {{ $topic->topic_title }}
                </div>
                <div class="topic-sub text-white mb-3">
                    {{-- optional subtitle if you have one: --}}
                    {{ $topic->topic_subtitle ?? '' }}
                </div>

                <button class="personal-leaderboard-btn mb-4">
                    PERSONAL LEADERBOARD
                </button>

                @foreach($topic->exercises as $exercise)
                   @php
        $ans       = $exercise->answers->first();
        $status    = $ans?->status   ?? 'Not Started';
        $feedback  = $ans?->feedback ?? null;
      @endphp

      <div class="exercise-row bg-[#111d33] p-4 rounded-lg neon-label flex items-start justify-between mb-3">
        <div class="flex flex-col">
          {{-- Line 1: Title --}}
          <div class="font-bold text-[#15f7fc]">
            {{ $exercise->exercise_title }}
          </div>

          {{-- Line 2: Status --}}
          <div class="text-sm text-[#13e2be] mt-1">
            STATUS: {{ $status }}
          </div>

          {{-- Line 3: Feedback (only if present) --}}
          @if($feedback)
            <div class="text-sm text-[#13e2be] mt-1">
              {{ $feedback }}
            </div>
          @endif
        </div>

        {{-- Leaderboard button stays to the right --}}
        <a
          href="{{ route('leaderboard.overall', [$exercise->id, auth()->id()]) }}"
          class="view-leaderboard-btn ml-4 self-center"
        >
          LEADERBOARD
        </a>
      </div>
                @endforeach

                </div>
            @endforeach

            </div>


            </div>

            </div>
    </main>
</div>

<style>
    
.neon-frame {
    background: rgba(10, 10, 30, 0.97);
    border: 3px solid #15f7fc;
    border-radius: 18px;
    box-shadow: 0 0 18px 3px #15f7fc, 0 0 38px 1px #15f7fc44 inset, 0 0 0 7px #061928;
    position: relative;
    overflow: hidden;
}
.neon-frame:before {
    content: '';
    position: absolute;
    inset: 0;
    border-radius: inherit;
    border: 2px solid #19ffe7;
    filter: blur(3px);
    opacity: 0.22;
    pointer-events: none;
}
.edit-btn {
    background: #0bffe7;
    color: #09304d;
    border: none;
    border-radius: 8px;
    padding: 7px 20px;
    font-size: 1rem;
    font-weight: bold;
    box-shadow: 0 0 8px #0fffc788;
    cursor: pointer;
    transition: 0.18s;
    letter-spacing: 1px;
}
.edit-btn:hover {
    background: #13e2be;
    color: #fff;
    box-shadow: 0 0 16px #15f7fcbb;
}
.personal-leaderboard-btn {
    margin-top: 8px;
    background: linear-gradient(90deg, #15f7fc 60%, #12e0be 100%);
    color: #09304d;
    padding: 7px 19px;
    border-radius: 7px;
    font-size: 1rem;
    font-weight: bold;
    border: none;
    box-shadow: 0 0 7px #12e0be66;
    cursor: pointer;
    transition: 0.18s;
    letter-spacing: 0.5px;
}
.personal-leaderboard-btn:hover {
    color: #fff;
    background: linear-gradient(90deg, #13e2be 40%, #15f7fc 100%);
    box-shadow: 0 0 18px #13e2be99;
}
.view-leaderboard-btn {
    background: linear-gradient(90deg, #15f7fc 60%, #12e0be 100%);
    color: #0a2431;
    padding: 7px 19px;
    border-radius: 7px;
    font-size: 1rem;
    font-weight: bold;
    border: none;
    box-shadow: 0 0 7px #15f7fc66;
    cursor: pointer;
    transition: 0.18s;
}
.view-leaderboard-btn:hover {
    background: linear-gradient(90deg, #13e2be 40%, #15f7fc 100%);
    color: #fff;
    box-shadow: 0 0 20px #15f7fc88;


    .neon-card {
        background: rgba(8, 15, 35, 0.92);
        border: 3px solid #15f7fc;
        border-radius: 20px;
        box-shadow:
            0 0 24px 0 #15f7fc99,
            0 0 60px 2px #13bcff66 inset;
        position: relative;
        transition: box-shadow 0.2s, border 0.2s;
    }
    .neon-card:hover {
        box-shadow:
            0 0 34px 4px #00ffffaa,
            0 0 80px 4px #15f7fc55 inset;
        border-color: #13e2be;
    }

    .neon-label {
        background: rgba(8, 15, 35, 0.97);
        border: 3px solid #15f7fc;
        border-radius: 12px;
        box-shadow:
            0 0 12px #15f7fc88,
            0 0 28px #15f7fc44 inset;
        letter-spacing: 1.5px;
    }
    .custom-scroll::-webkit-scrollbar {
        width: 8px;
        background: transparent;
    }
    .custom-scroll::-webkit-scrollbar-thumb {
        background: #13e2be44;
        border-radius: 6px;
    }


    .neon-frame {
        background: rgba(10, 10, 30, 0.90);
        border: 3px solid #15f7fc;
        border-radius: 24px;
        box-shadow:
            0 0 18px 3px #15f7fc,
            0 0 38px 1px #00bfff85 inset,
            0 0 0 7px #061928;
        position: relative;
        overflow: hidden;
    }
    .neon-frame:before,
    .neon-frame:after {
        content: '';
        position: absolute;
        pointer-events: none;
        border-radius: inherit;
    }
    .neon-frame:before {
        inset: 0;
        border: 2px solid #19ffe7;
        filter: blur(3px);
        opacity: 0.55;
    }
    .neon-frame:after {
        inset: 8px;
        border: 2px solid #19ffe75c;
        filter: blur(7px);
        opacity: 0.3;
    }
    .neon-frame h2,
    .neon-frame h3,
    .neon-frame span,
    .neon-frame .text-white {
        color: #15f7fc !important;
        text-shadow: 0 0 12px #15f7fc99, 0 2px 14px #00284999;
        letter-spacing: 1.5px;
    }
    aside.fixed {
        background: linear-gradient(160deg, #0a132a 70%, #14e1ee3c 100%);
        border-right: 3.5px solid #13e2be;
        box-shadow: 0 0 12px #13e2be44, 0 4px 24px #0a243155;
    }
    aside.fixed .text-2xl {
        color: #13e2be !important;
        text-shadow: 0 0 8px #13e2be77;
    }
    aside.fixed nav a {
        background: transparent;
        border: 2px solid transparent;
        border-radius: 2px;
        color: #c9fbff;
        font-weight: 500;
        transition: all 0.18s;
        letter-spacing: 1.2px;
    }
    aside.fixed nav a:hover,
    aside.fixed nav a.active {
        background: #142755bb;
        border-color: #15f7fc;
        color: #15f7fc;
        box-shadow: 0 0 10px #15f7fc44;
    }
    header.fixed {
        background: #071c2d;
        box-shadow: 0 1px 10px #14e1ee33;
        color: #13e2be;
    }
    header .font-semibold {
        color: #15f7fc;
        text-shadow: 0 0 6px #15f7fcaa;
    }
    body, .min-h-screen {
        background: #050e1a;
    }
}

<style>
/* Neon styles, copy from your dashboard CSS if not already loaded globally */
.neon-frame {
    background: rgba(10, 10, 30, 0.90);
    border: 3px solid #15f7fc;
    border-radius:15px;
    box-shadow:
        0 0 18px 3px #15f7fc,
        0 0 38px 1px #00bfff85 inset,
        0 0 0 7px #061928;
    position: relative;
    overflow: hidden;
}
.neon-frame:before,
.neon-frame:after {
    content: '';
    position: absolute;
    pointer-events: none;
    border-radius: inherit;
}
.neon-frame:before {
    inset: 0;
    border: 2px solid #19ffe7;
    filter: blur(3px);
    opacity: 0.55;
}
.neon-frame:after {
    inset: 8px;
    border: 2px solid #19ffe75c;
    filter: blur(7px);
    opacity: 0.3;
}
.neon-frame h2,
.neon-frame h3,
.neon-frame span,
.neon-frame .text-white {
    color: #15f7fc !important;
    text-shadow: 0 0 12px #15f7fc99, 0 2px 14px #00284999;
    letter-spacing: 1.5px;
}
aside.fixed {
    background: linear-gradient(160deg, #0a132a 70%, #14e1ee3c 100%);
    border-right: 3.5px solid #13e2be;
    box-shadow: 0 0 12px #13e2be44, 0 4px 24px #0a243155;
}
aside.fixed .text-2xl {
    color: #13e2be !important;
    text-shadow: 0 0 8px #13e2be77;
}
aside.fixed nav a {
    background: transparent;
    border: 2px solid transparent;
    border-radius: 2px;
    color: #c9fbff;
    font-weight: 500;
    transition: all 0.18s;
    letter-spacing: 1.2px;
}
aside.fixed nav a:hover,
aside.fixed nav a.active {
    background: #142755bb;
    border-color: #15f7fc;
    color: #15f7fc;
    box-shadow: 0 0 10px #15f7fc44;
}
header.fixed {
    background: #071c2d;
    box-shadow: 0 1px 10px #14e1ee33;
    color: #13e2be;
}
header .font-semibold {
    color: #15f7fc;
    text-shadow: 0 0 6px #15f7fcaa;
}
body, .min-h-screen {
    background: #050e1a;
}
.topics-scroll {
    scrollbar-width: thin;
    scrollbar-color: #13e2be #101b2a;
    scroll-behavior: smooth;
}
.topics-scroll::-webkit-scrollbar {
    height: 12px;
    background: #101b2a;
}
.topics-scroll::-webkit-scrollbar-thumb {
    background: #13e2be;
    border-radius: 6px;
    box-shadow: 0 0 10px #15f7fc66;
}
.progress-topic-card {
    box-shadow: 0 0 18px 2px #15f7fc22, 0 0 32px #13e2be22 inset;
    transition: box-shadow 0.18s, border 0.18s;
}
.progress-topic-card:hover {
    box-shadow: 0 0 28px 7px #13e2be77;
    border-color: #15f7fc;
}
.neon-label {
    border: 2px solid #15f7fc55;
}

</style>
</x-app-layout>
