{{-- <x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        @if (session('status'))
        <div class="mb-4 font-medium text-sm text-green-600">
            {{ session('status') }}
        </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <x-label for="email" value="{{ __('Email') }}" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required
                    autofocus autocomplete="username" />
            </div>

            <div class="mt-4">
                <x-label for="password" value="{{ __('Password') }}" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required
                    autocomplete="current-password" />
            </div>

            <div class="block mt-4">
                <label for="remember_me" class="flex items-center">
                    <x-checkbox id="remember_me" name="remember" />
                    <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
                @endif

                <x-button class="ms-4">
                    {{ __('Log in') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout> --}}

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Callista LK</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/auth.css') }}">
</head>

<body class="auth-body">
    <!-- Back Button -->
    <a href="@if(request()->routeIs('admin.login')) /admin/login @else / @endif" class="back-home">
        <i class="fas fa-arrow-left"></i> 
        @if(request()->routeIs('admin.login'))
            Back to Admin
        @else
            Back to Home
        @endif
    </a>

    <div class="auth-container">
        <!-- Left Side - Image/Brand -->
        <div class="auth-left">
            <div class="auth-brand">
                <img src="{{ asset('assets/images/logo.png') }}" alt="Callista LK">
                <h1>Callista<span>LK</span></h1>
            </div>
            <div class="auth-content">
                <h2>Welcome Back!</h2>
                <p>Log in to access your account and continue shopping for premium furniture and home decor.</p>
                <ul class="auth-features">
                    <li><i class="fas fa-check-circle"></i> Exclusive member discounts</li>
                    <li><i class="fas fa-check-circle"></i> Track your orders easily</li>
                    <li><i class="fas fa-check-circle"></i> Save your favorite items</li>
                    <li><i class="fas fa-check-circle"></i> Fast & secure checkout</li>
                </ul>
            </div>
        </div>

        <!-- Right Side - Login Form -->
        <div class="auth-right">
            <div class="auth-form-container">
                <div class="auth-header">
                    <h2>
                        @if(request()->routeIs('admin.login'))
                            Admin Sign In
                        @else
                            Sign In
                        @endif
                    </h2>
                    <p>
                        @if(request()->routeIs('admin.login'))
                            Enter your admin credentials to access the admin panel
                        @else
                            Enter your credentials to access your account
                        @endif
                    </p>
                </div>

                <!-- Social Login -->
                <div class="social-login">
                    <button class="social-btn google">
                        <i class="fab fa-google"></i> Continue with Google
                    </button>
                    <button class="social-btn facebook">
                        <i class="fab fa-facebook-f"></i> Continue with Facebook
                    </button>
                </div>

                <div class="divider">
                    <span>OR</span>
                </div>

                <!-- Validation Errors -->
                @if ($errors->any())
                <div class="alert alert-danger">
                    <div class="font-medium text-red-600">Whoops! Something went wrong.</div>
                    <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                @if (session('status'))
                <div class="mb-4 font-medium text-sm text-green-600">
                    {{ session('status') }}
                </div>
                @endif

                <!-- Login Form -->
                <form method="POST" class="auth-form" action="{{ route('login') }}">
                    @csrf
                    <div class="form-group">
                        <label for="email">
                            <i class="fas fa-envelope"></i> Email Address
                        </label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}"
                            placeholder="your.email@example.com" required autofocus autocomplete="username">
                        @error('email')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password">
                            <i class="fas fa-lock"></i> Password
                        </label>
                        <div class="password-input-group">
                            <input type="password" id="password" name="password" placeholder="Enter your password"
                                required autocomplete="current-password">
                            <button type="button" class="toggle-password" aria-label="Toggle password visibility">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        @error('password')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-row">
                        <label class="checkbox-label">
                            <input type="checkbox" name="remember" id="remember">
                            <span>Remember me</span>
                        </label>
                        @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="forgot-password">Forgot Password?</a>
                        @endif
                    </div>

                    <button type="submit" class="btn btn-primary btn-full">
                        <i class="fas fa-sign-in-alt"></i> Sign In
                    </button>
                </form>

                <div class="auth-footer">
                    <p>Don't have an account? <a href="{{ route('register') }}">Sign Up</a></p>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/js/auth.js') }}"></script>

</body>

</html>