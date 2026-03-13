<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Add Employee</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg p-6">

                @if($errors->any())
                    <div class="mb-4 p-4 bg-red-100 text-red-800 rounded">
                        <ul class="list-disc list-inside text-sm">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('hr.employees.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="grid grid-cols-2 gap-4">

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Employee ID</label>
                            <input type="text" name="employee_id" value="{{ old('employee_id') }}"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Date Hired</label>
                            <input type="date" name="date_hired" value="{{ old('date_hired') }}"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">First Name</label>
                            <input type="text" name="first_name" value="{{ old('first_name') }}"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Last Name</label>
                            <input type="text" name="last_name" value="{{ old('last_name') }}"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" name="email" value="{{ old('email') }}"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Phone</label>
                            <input type="text" name="phone" value="{{ old('phone') }}"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Department</label>
                            <input type="text" name="department" value="{{ old('department') }}"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Position</label>
                            <input type="text" name="position" value="{{ old('position') }}"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Employment Status</label>
                            <select name="employment_status"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                <option value="active" {{ old('employment_status') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('employment_status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                <option value="resigned" {{ old('employment_status') == 'resigned' ? 'selected' : '' }}>Resigned</option>
                                <option value="terminated" {{ old('employment_status') == 'terminated' ? 'selected' : '' }}>Terminated</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Profile Photo</label>
                            <input type="file" name="profile_photo" accept="image/*"
                                class="mt-1 block w-full text-sm text-gray-500">
                            <p class="text-xs text-gray-400 mt-1">Optional. JPG or PNG, max 10MB.</p>
                        </div>

                    </div>

                    <div class="mt-6 flex gap-3">
                        <button type="submit"
                            class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                            Save Employee
                        </button>
                        <a href="{{ route('hr.employees.index') }}"
                            class="bg-gray-200 text-gray-700 px-6 py-2 rounded hover:bg-gray-300">
                            Cancel
                        </a>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>