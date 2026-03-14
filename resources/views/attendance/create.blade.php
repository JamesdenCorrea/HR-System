<x-app-layout>
    <x-slot name="title">Attendance Records</x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Manual Attendance Entry</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-lg mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg p-6">

                @if(session('error'))
                    <div class="mb-4 p-4 bg-red-100 text-red-800 rounded">
                        {{ session('error') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="mb-4 p-4 bg-red-100 text-red-800 rounded">
                        <ul class="list-disc list-inside text-sm">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Real-time clock display --}}
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6 text-center">
                    <p class="text-blue-500 text-xs uppercase tracking-wide mb-1">Current Server Time</p>
                    <p class="text-3xl font-bold text-blue-700" id="live-clock">--:-- --</p>
                    <p class="text-blue-500 text-xs mt-1">Time will be recorded automatically on submit</p>
                </div>

                <form method="POST" action="{{ route('hr.attendance.store') }}">
                    @csrf

                    <div class="space-y-4">

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Employee</label>
                            <select name="employee_id"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                <option value="">Select Employee</option>
                                @foreach($employees as $emp)
                                    <option value="{{ $emp->id }}"
                                        {{ old('employee_id') == $emp->id ? 'selected' : '' }}>
                                        {{ $emp->full_name }} ({{ $emp->employee_id }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Date</label>
                            <input type="date" name="date"
                                value="{{ old('date', now()->format('Y-m-d')) }}"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Status</label>
                            <select name="status"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                <option value="present" {{ old('status') == 'present' ? 'selected' : '' }}>Present</option>
                                <option value="late" {{ old('status') == 'late' ? 'selected' : '' }}>Late</option>
                                <option value="absent" {{ old('status') == 'absent' ? 'selected' : '' }}>Absent</option>
                                <option value="half-day" {{ old('status') == 'half-day' ? 'selected' : '' }}>Half Day</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Notes</label>
                            <textarea name="notes" rows="2"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                                placeholder="Optional notes...">{{ old('notes') }}</textarea>
                        </div>

                        <div class="bg-gray-50 rounded-lg p-3 text-sm text-gray-600">
                            <p>If no record exists for this employee on the selected date →
                                <span class="font-semibold text-green-700">Clock In</span> will be recorded.</p>
                            <p class="mt-1">If Clock In exists but no Clock Out →
                                <span class="font-semibold text-red-700">Clock Out</span> will be recorded.</p>
                        </div>

                    </div>

                    <div class="mt-6 flex gap-3">
                        <button type="submit"
                            class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                            Save Record
                        </button>
                        <a href="{{ route('hr.attendance.index') }}"
                            class="bg-gray-200 text-gray-700 px-6 py-2 rounded hover:bg-gray-300">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
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
            document.getElementById('live-clock').textContent = h + ':' + m + ':' + s + ' ' + ampm;
        }
        updateClock();
        setInterval(updateClock, 1000);
    </script>
</x-app-layout>