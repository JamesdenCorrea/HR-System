<x-app-layout>
    <x-slot name="title">My Account Requests</x-slot>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight"> Account Requests</h2>
            <a href="{{ route('account-requests.create') }} "
            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-sm">
            + New Request
</a>
</div>
</x-slot>

<div class="py-12">
    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
        @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-800 rounded"> {{ session('success') }}</div>
        @endif

        <div class="bg-white shadow-sm rounded-lg overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Role</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Department</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
</tr>
</thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse($request as $req)
            <tr>
                <td class="px-6 py-4 text-sm text-gray-900">{{ $req->name }}</td>
                <td class="px-6 py-4 text-sm text-gray-600">{{ $req->email }}</td>
                <td class="px-6 py-4 text-sm text-gray-600">{{ ucfirst($req->role) }}</td>
                <td class="px-6 py-4 text-sm text-gray-600">{{ $req->department ?? '-'}}</td>
                <td class="px-6 py-4">
                    <span class="px-2 py-2 text-xs rounded-full {{ $req->status_badge }}">
                        {{ucfirst($req->status) }}
</span>
</td>
<td class="px-6 py-4 text-sm text-gray-600">
    {{ $req->created_at->format('M d, Y') }}
</td>
</tr>
@empty
<tr>
    <td colspan="6" class="px-6 py-4 text-center text-gray-500">
        No account request yet.
</td>
</tr>
@endforelse
</tbody>
</table>
<div class="px-6 py-4"> {{ $request->links() }}</div>
</div>
</div>
</div>
</x-app-layout>