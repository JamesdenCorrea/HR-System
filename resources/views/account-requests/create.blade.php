<x-app-layout>
    <x-slot name="title"> Request Account</x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Request New Account</h2>
</x-slot>

<div class="py-12">
    <div class="max-w-lg mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-sm rounded-lg p-6">

        @if($errors->any())
        <div class="mb-4 p-4 bg-red-100 text-red-800 rounded">
            <ul class="list-disc list-inside text-sm">
                @foreach($errors->all() as $error)
                <li> {{ $error }}</li>
                @endforeach
</ul>
</div>
@endif

<form method="POST" action="{{ route('account-requests.store') }} ">
    @csrf
    <div class="space-y-4">
        <div>
            <label class="block text-sm font-medium text-gray-700">Full Name</label>
            <input type="text" name="name" value="{{ old('name') }}"
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
            placeholder="Juan dela Cruz">
</div>

    <div>
        <label class="block text-sm font-medium text-gray-700"> Email Address</label>
        <input type="text" name="email" value="{{ old('email') }}"
        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
        placeholder="juan@company.com">
</div>

    <div>
        <label class="block text-sm font-medium text-gray-700"> Role</label>
        <select name="role" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            <option value="">Select Role</option>
            <option value="hr" {{ old('role') == 'hr' ? 'selected' : '' }}>HR</option>
            <option value="employee" {{ old('role') == 'employee' ? 'selected' : '' }}>Employee</option>
</select>
</div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Department</label>
        <input type="text" name="department" value="{{ old('department') }}"
        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
        placeholder="IT Department">
</div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Position</label>
        <input type="text" name="position" value="{{ old('position') }}"
        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
        placeholder="IT Programmer">
</div>
</div>

    <div class="mt-6 flex gap-3">
        <button type="submit"
        class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
        Submit Request
</button>
<a href="{{ route('account-requests.index') }} "
class="bg-gray-200 text-gray-700 px-6 py-2 rounded hover:bg-gray-300">
Cancel
</a>
</div>
</form>
</div>
</div>
</div>
</x-app-layout>
