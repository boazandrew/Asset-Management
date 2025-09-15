@extends('layouts.app')

@section('title', 'Login - Asset Management System')

@section('content')
<div class="d-flex min-vh-100 align-items-center justify-content-center bg-light py-5 px-3">
    <div class="col-12 col-sm-10 col-md-8 col-lg-5 bg-white p-4 p-md-5 rounded-3 shadow">
        <div class="text-center mb-4">
            <h2 class="fw-bold text-dark">Asset Management System</h2>
            <p class="text-muted small">Sign in to your account</p>
        </div>

        <form class="mt-3" action="{{ route('login') }}" method="POST">
            @csrf
            <div class="mb-3">
                <!-- Email -->
                <label for="email" class="form-label small fw-semibold">Email Address</label>
                <input id="email" name="email" type="email" required
                    class="form-control form-control-sm"
                    placeholder="Enter your email" value="{{ old('email') }}">
            </div>

            <!-- Password -->
            <div class="mb-3">
                <label for="password" class="form-label small fw-semibold">Password</label>
                <div class="input-group">
                    <input id="password" name="password" type="password" required
                        class="form-control form-control-sm"
                        placeholder="Enter your password">
                    <button type="button" id="togglePassword" class="btn btn-outline-secondary" style="border-color: #ced4da !important; box-shadow:none;">
                        <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5
                                  c4.477 0 8.268 2.943 9.542 7
                                  -1.274 4.057-5.065 7-9.542 7
                                  -4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </button>
                </div>
            </div>

            <div class="d-grid mt-4">
                <button type="submit" class="btn btn-primary btn-sm">
                    Sign in
                </button>
            </div>
        </form>

        <!-- Demo Credentials -->
        <div class="mt-5 p-3 rounded bg-light border">
            <h3 class="small fw-bold text-primary mb-2">Demo Credentials</h3>
            <ul class="list-unstyled small text-secondary mb-0">
                <li><strong>Admin:</strong> admin@email.com / admin123</li>
                <li><strong>User:</strong> user1@email.com / user123</li>
                <li><strong>User:</strong> user2@email.com / user123</li>
                <li><strong>User:</strong> user3@email.com / user123</li>
            </ul>
        </div>
    </div>
</div>

<!-- Password -->
<style>
    /* Make eye button blend with input */
    .input-group .btn {
        border-color: #ced4da !important;
    }

    /* Remove button glow on focus */
    .input-group .btn:focus {
        box-shadow: none !important;
    }

    /* Keep input glow working */
    .input-group .form-control:focus {
        border-color: #86b7fe;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, .25);
    }
</style>

<script>
    const togglePassword = document.querySelector("#togglePassword");
    const passwordField = document.querySelector("#password");
    const eyeIcon = document.querySelector("#eyeIcon");

    togglePassword.addEventListener("click", () => {
        const type = passwordField.type === "password" ? "text" : "password";
        passwordField.type = type;

        if (type === "text") {
            eyeIcon.setAttribute("stroke", "blue");
        } else {
            eyeIcon.setAttribute("stroke", "currentColor");
        }
    });
</script>
@endsection