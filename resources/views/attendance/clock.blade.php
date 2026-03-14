<x-app-layout>
    <x-slot name="title">My Attendance</x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">My Attendance</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-lg mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 p-4 bg-red-100 text-red-800 rounded">
                    {{ session('error') }}
                </div>
            @endif

            @if(!$employee)
                <div class="bg-yellow-100 text-yellow-800 p-4 rounded">
                    Your account is not linked to an employee record.
                    Please contact HR.
                </div>
            @else
                <div class="bg-white shadow-sm rounded-lg p-6 text-center">

                    <p class="text-gray-500 text-sm">{{ now()->format('l, F d, Y') }}</p>
                    <p class="text-4xl font-bold text-gray-800 mt-1" id="clock">--:-- --</p>

                    <div class="mt-6 grid grid-cols-2 gap-4 text-sm text-left">
                        <div class="bg-gray-50 p-3 rounded">
                            <p class="text-gray-500 text-xs uppercase tracking-wide">Clock In</p>
                            <p class="font-semibold text-gray-800 text-lg">
                                {{ $attendance?->clock_in
                                    ? \Carbon\Carbon::parse($attendance->clock_in)->format('h:i A')
                                    : '—' }}
                            </p>
                        </div>
                        <div class="bg-gray-50 p-3 rounded">
                            <p class="text-gray-500 text-xs uppercase tracking-wide">Clock Out</p>
                            <p class="font-semibold text-gray-800 text-lg">
                                {{ $attendance?->clock_out
                                    ? \Carbon\Carbon::parse($attendance->clock_out)->format('h:i A')
                                    : '—' }}
                            </p>
                        </div>
                        <div class="bg-gray-50 p-3 rounded">
                            <p class="text-gray-500 text-xs uppercase tracking-wide">Status</p>
                            <p class="font-semibold text-gray-800">
                                {{ $attendance ? ucfirst($attendance->status) : '—' }}
                            </p>
                        </div>
                        <div class="bg-gray-50 p-3 rounded">
                            <p class="text-gray-500 text-xs uppercase tracking-wide">Work Hours</p>
                            <p class="font-semibold text-gray-800">
                                {{ $attendance?->work_hours ?? '—' }}
                            </p>
                        </div>
                    </div>

                    <div class="mt-8">
                        {{-- NOT YET CLOCKED IN --}}
                        @if(!$attendance || !$attendance->clock_in)
                            <p class="text-gray-500 text-sm mb-3">You have not clocked in yet today.</p>
                            <form method="POST" action="{{ route('attendance.clock-in') }}">
                                @csrf
                                <button type="submit"
                                    class="w-full bg-green-600 text-white py-4 rounded-xl hover:bg-green-700 font-bold text-lg tracking-wide">
                                    CLOCK IN
                                </button>
                            </form>

                        {{-- CLOCKED IN BUT NOT YET CLOCKED OUT --}}
                        @elseif($attendance->clock_in && !$attendance->clock_out)
                            <p class="text-gray-500 text-sm mb-3">
                                You clocked in at
                                <span class="font-semibold text-gray-700">
                                    {{ \Carbon\Carbon::parse($attendance->clock_in)->format('h:i A') }}
                                </span>.
                                Ready to leave?
                            </p>
                            <form method="POST" action="{{ route('attendance.clock-out') }}">
                                @csrf
                                <button type="submit"
                                    class="w-full bg-red-600 text-white py-4 rounded-xl hover:bg-red-700 font-bold text-lg tracking-wide">
                                    CLOCK OUT
                                </button>
                            </form>

                        {{-- BOTH CLOCKED IN AND OUT --}}
                        @else
                            <div class="bg-green-50 border border-green-200 rounded-xl p-4">
                                <p class="text-green-700 font-semibold text-lg">✓ Attendance Complete</p>
                                <p class="text-green-600 text-sm mt-1">
                                    You worked {{ $attendance->work_hours }} today.
                                </p>
                            </div>
                        @endif
                    </div>

                </div>
            @endif
        </div>
    </div>

    <script>
        function updateClock() {
            const now = new Date();
            let h = now.getHours();
            const m = String(now.getMinutes()).padStart(2, '0');
            const s = String(now.getSeconds()).padStart(2, '0');
            const ampm = h >= 12 ? 'PM' : 'AM';
            h = h % 12 || 12;
            document.getElementById('clock').textContent = h + ':' + m + ':' + s + ' ' + ampm;
        }
        updateClock();
        setInterval(updateClock, 1000);
    </script>
</x-app-layout>