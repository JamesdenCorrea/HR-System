<x-app-layout>
    <x-slot name="title"> Account Request - Admin</x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight"> Account Requests </h2>
</x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
        @endif
        @if(session('error'))
        <div class="mb-4 p-4 bg-red-100 text-red-800 rounded"> {{ session('error') }}</div>
        @endif

        <div class="bg-white shadow-sm rounded-lg overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Role</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Department</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Position</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Requested By</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase"> Actions</th>
</tr>
</thead>
<tbody class="bg-white divide-y divide-gray-200">
    @forelse($request as $req)
    <tr>
        <td class="px-6 py-4 text-sm text-gray-900">{{ $req->name }}</td>
        <td class="px-6 py-4 text-sm text-gray-600">{{ $req->email }}</td>
        <td class="px-6 py-4 text-sm text-gray-600">{{ ucfirst($req->role) }}</td>
        <td class="px-6 py-4 text-sm text-gray-600"> {{ $req->department ?? '-' }}</td>
        <td class="px-6 py-4 text-sm text-gray-600"> {{ $req->position ?? '-' }}</td>
        <td class="px-6 py-4 text-sm text-gray-600"> {{ $req->requestedBy?->name ?? '-' }}</td>
        <td class="px-6 py-4">
            <span class="px-2 py-1 text-xs rounded-full {{ $req->status_badge}}">
                {{ ucfirst($req->status) }}
</span>
</td>
<td class="px-6 py-4 text-sm">
    @if($req->status === 'pending')
    <form method="POST"
    action="{{ route('admin.account-requests.approve', $req) }}"
    class="inline">
    @csrf
    <button type="submit"
    class="text-green-600 hover:underline mr-2"
    onClick="return confirm('Approve and send credentials to {{ $req->email }}?')">
    Approve
</button>
</form>
<button onclick="toggleReject({{ $req->id }})"
class="text-red-600 hover:underline">
Reject
</button>

<div id="reject-{{ $req->id }}" class="hidden mt-2">
    <form method="POST"
    action="{{ route('admin.account-requests.reject', $req) }}">
    @csrf
    <textarea name="rejection_reason" rows="2"
    placeholder="Reason for rejection..."
    class="w-full border-gray-300 rounded text-sm p-2 mb-1"></textarea>
    <button type="submit"
    class="bg-red-600 text-white px-3 py-1 rounded text-xs hover:bg-red-700">
    Confirm Reject
</button>
</form>
</div>
@else
<span class="text-gray-400 text-xs">Processed</span>
@endif
</td>
</tr>
@empty
<tr>
    <td colspan="8" class="px-6 py-4 text-center text-gray-500">
        No account requests found.
</td>
</tr>
@endforelse
</tbody>
</table>
<div class="px-6 py-4">{{ $request->links() }}</div>
</div>
</div>
</div>
<script>
    function toggleReject(id){
        const div = document.getElementById('reject-' + id);
        div.classList.toggle('hidden');
    }
    </script>
    </x-app-layout>