<x-app-layout>
    <x-slot name="title">File Leave</x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight"> File a Leave Request</h2>
</x-slot>

<div class="py-12">
    <div class="max-w-lg mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-sm rounded-lg p-6">
            
        @if(session('error'))
        <div class="mb-4 p-4 bg-red-100 text-red-800 rounded"> {{ session('error') }}</div>
        @endif

        @if($errors->any())
        <div class="mb-4 p-4 bg-red-100 text-red-800 rounded">
            <ul class="list-disc list-inside text-sm">
                @foreach($errors->all() as $error)
                <li> {{ $error }}</li>
                @endforeach
</ul>
</div>
@endif

        {{-- Balance Summarry --}}
        <div class="grid grid-cols-3 gap-2 mb-6 text-center text-xs">
            <div class="bg-blue-50 rounded p-2">
                <p class="text-gray-500">Vacation</p>
                <p class="font-bold text-blue-600 text-lg">{{ $balance->vacation_remaining }}</p>
                <p class="text-gray-400">days left</p>
</div>
        <div class="bg-green-50 rounded p-2">
            <p class="text-gray-500">Sick</p>
            <p class="font-bold text-green-600 text-lg">{{ $balance->sick_remaining }}</p>
            <p class="text-gray-400">days left</p>
</div>
        <div class="bg-red-50 rounded-p2">
            <p class="text-gray-500">Emergency</p>
            <p class="font-bold text-red-600 text-lg">{{ $balance->emergency_remaining }}</p>
            <p class="text-gray-400">days left</p>
</div>
</div>

<form method="POST" action="{{ route('leaves.store') }}">
    @csrf
    <div class="space-y-4">

        <div>
            <label class="block text-sm font-medium text-gray-700">Leave Type</label>
            <select name="leave_type"
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            <option value="">Select Type</option>
            <option value="vacation" {{ old ('leave_type') == 'vacation' ? 'selected' : '' }}>
                Vacation Leave ({{ $balance->vacation_remaining }} days left)
</option>
            <option value="sick" {{ old ('leave_type') == 'sick' ? 'selected' : '' }}>
                Sick Leave ({{ $balance->sick_remaining }} days left)
</option>
            <option value="emergency" {{old ('leave_type') == 'emergency' ? 'selected' : '' }}>
                Emergency Leave ({{ $balance->emergency_remaining }} days left)
</option>
</select>
</div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700"> Start Date </label>
                <input type="date" name="start_date"
                value="{{ old('start_date') }} "
                min="{{ now()->format('Y-m-d') }} "
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
</div>

        <div>
            <label class="block text-sm font-medium text-gray-700"> End Date </label>
            <input type="date" name="end_date"
            value="{{ old('end_date') }} "
            min="{{ now()->format('Y-m-d') }} "
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
</div>
</div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Reason</label>
            <textarea name="reason" rows="3"
            placeholder="Please provide the reason for your leave..."
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"> {{ old ('reason') }}</textarea>
</div>
</div>

        <div class="mt-6 flex gap-3">
            <button type="submit"
            class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
            Submit Request
</button>
<a href="{{ route('leaves.my') }}"
class="bg-gray-200 text-gray-700 px-6 py-2 rounded hover:bg-gray-300">
Cancel
</a>
</div>
</form>
</div>
</div>
</div>
</x-app-layout>
