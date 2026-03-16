<x-app-layout>
    <x-slot name="title">Reports</x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Reports</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 gap-6">

                <a href="{{ route('hr.reports.employees') }}"
                   class="bg-white shadow-sm rounded-lg p-6 hover:shadow-md transition group">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            <span class="text-blue-600 text-2xl">👥</span>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-800 group-hover:text-blue-600">
                                Employee Report
                            </h3>
                            <p class="text-gray-400 text-sm">Full employee list with details</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('hr.reports.attendance') }}"
                   class="bg-white shadow-sm rounded-lg p-6 hover:shadow-md transition group">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                            <span class="text-green-600 text-2xl">📋</span>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-800 group-hover:text-green-600">
                                Attendance Report
                            </h3>
                            <p class="text-gray-400 text-sm">Monthly attendance records</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('hr.reports.leaves') }}"
                   class="bg-white shadow-sm rounded-lg p-6 hover:shadow-md transition group">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                            <span class="text-yellow-600 text-2xl">🏖️</span>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-800 group-hover:text-yellow-600">
                                Leave Report
                            </h3>
                            <p class="text-gray-400 text-sm">Leave requests and approvals</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('hr.reports.payroll') }}"
                   class="bg-white shadow-sm rounded-lg p-6 hover:shadow-md transition group">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                            <span class="text-purple-600 text-2xl">💰</span>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-800 group-hover:text-purple-600">
                                Payroll Report
                            </h3>
                            <p class="text-gray-400 text-sm">Released payroll summary</p>
                        </div>
                    </div>
                </a>

            </div>
        </div>
    </div>
</x-app-layout>