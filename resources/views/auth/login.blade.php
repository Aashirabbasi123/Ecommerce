@extends('user.components.master')

@section('content')
@include('user.components.navbar')

<main class="pt-90">
    <div class="mb-4 pb-4"></div>
    <section class="login-register container">
        <ul class="nav nav-tabs mb-5" id="login_register" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link nav-link_underscore active" id="login-tab" data-bs-toggle="tab" href="#tab-item-login"
                    role="tab" aria-controls="tab-item-login" aria-selected="true">Login</a>
            </li>
        </ul>

        <div class="tab-content pt-2" id="login_register_tab_content">
            <div class="tab-pane fade show active" id="tab-item-login" role="tabpanel" aria-labelledby="login-tab">
                <div class="login-form">
                    <form method="POST" action={{ route('login') }} name="login-form" class="needs-validation" novalidate>
                        @csrf

                        {{-- Email Input --}}
                        <div class="form-floating mb-3">
                            <input id="email" type="email" class="form-control form-control_gray" name="email"
                                value="{{ old('email') }}" required autofocus autocomplete="username">
                            <label for="email">Email address *</label>

                            @error('email')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="pb-3"></div>

                        {{-- Password Input --}}
                        <div class="form-floating mb-3">
                            <input id="password" type="password" class="form-control form-control_gray"
                                name="password" required autocomplete="current-password">
                            <label for="password">Password *</label>

                            @error('password')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Remember Me --}}
                        <div class="block mt-4">
                            <label for="remember_me" class="inline-flex items-center">
                                <input id="remember_me" type="checkbox"
                                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                                    name="remember">
                                <span class="ms-2 text-sm text-gray-600">Remember me</span>
                            </label>
                        </div>

                        {{-- Submit Button --}}
                        <button class="btn btn-primary w-100 text-uppercase mt-3" type="submit">Log In</button>

                        {{-- Register Link --}}
                        <div class="customer-option mt-4 text-center">
                            <span class="text-secondary">No account yet?</span>
                            <a href="{{ route('register') }}" class="btn-text js-show">Register Now</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</main>

@include('user.components.footer')
@endsection
