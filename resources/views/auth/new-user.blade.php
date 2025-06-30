<x-guest-layout>
    <form method="POST" action="{{ route('new-user.send') }}">
    @csrf
    <input type="email" name="email" required />
    <button type="submit">Send Temporary Password</button>
</form>

</x-guest-layout>
