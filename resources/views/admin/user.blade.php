@extends('layouts.admin')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Registered Users</h2>

    <table class="table table-bordered table-striped">
        <thead class="bg-dark text-white">
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Registered At</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->created_at->format('d M, Y h:i A') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center">No users registered yet.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {{ $users->links() }}
    </div>
</div>
@endsection
