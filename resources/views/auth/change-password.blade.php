<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        <strong> Security Notice: </strong> You must change your temporary password before continuing.
</div>

@if(session('success'))
<div class="mb-4 p-4 bg-green-100 text-green-800 rounded text-sm"> {{ session('success') }}</div>
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

<form method="POST" action="{{ route('password.change.update') }}">
    @csrf

    <div class="mb-4">
        <x-input-label for="password" value="New Password" />
        <x-text-input id="password" type="password" name="password"
            class="mt-1 block w-full" required autocomplete="new-password"/>
</div>

<div class="mb-4">
    <x-input-label for="password_confirmation" value="Confirm New Password"/>
    <x-text-input id="password_confirmation" type="password" name="password_confirmation"
    class="mt-1 block-wfull" required autocomplete="new-password"/>
</div>

<div class="flex justify-end">
    <x-primary-button>Set New Password</x-primary-button>
</div>
</form>
</x-guest-layout>