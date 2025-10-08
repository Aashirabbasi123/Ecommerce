@extends('layouts.admin')

@section('content')
@push('styles')
<style>
    .table td, .table th {
        vertical-align: middle;
        white-space: nowrap;
    }

    .card-header h4 {
        font-weight: 600;
    }
</style>
@endpush

<div class="container py-5">

    <div class="row justify-content-center">
        <div class="col-12 col-lg-10">

            <div class="card border-0 shadow rounded">
                <div class="card-header bg-primary text-white text-center">
                    <h4 class="mb-0">👥 Registered Users</h4>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover mb-0">
                            <thead class="table-dark">
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
                                    <td colspan="4" class="text-center text-muted py-4">
                                        <i class="bi bi-person-x fs-4 d-block mb-2"></i>
                                        No users registered yet.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                @if($users->hasPages())
                <div class="card-footer bg-white d-flex justify-content-center py-3">
                    {{ $users->links('pagination::bootstrap-5') }}
                </div>
                @endif

            </div>

        </div>
    </div>

</div>
@endsection
