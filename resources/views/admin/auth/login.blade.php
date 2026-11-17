<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>Admin Login | Department of Land Title Settlement</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Figtree:ital,wght@0,300..900;1,300..900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>

<body class="login-body">

    <main class="login-card">
        <div class="login-brand">
            <img src="{{ asset('images/landTitle.jpg') }}" alt="Department emblem">
            <div>
                <div class="login-brand-title">Department of Land Title Settlement</div>
                <div class="login-brand-sub">Admin Panel</div>
            </div>
        </div>

        <h1>Sign in</h1>
        <p class="login-intro">Enter your admin email and password to continue.</p>

        @if(session('status'))
            <div class="alert alert-success" role="status">{{ session('status') }}</div>
        @endif

        <form method="POST" action="{{ route('admin.login.submit') }}" novalidate>
            @csrf

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" autocomplete="username"
                    autofocus class="form-input @error('email') is-invalid @enderror">
                @error('email')
                    <small class="form-error">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" autocomplete="current-password"
                    class="form-input @error('password') is-invalid @enderror">
                @error('password')
                    <small class="form-error">{{ $message }}</small>
                @enderror
            </div>

            <label class="form-check">
                <input type="checkbox" name="remember" value="1" {{ old('remember') ? 'checked' : '' }}>
                <span>Keep me signed in</span>
            </label>

            <button type="submit" class="btn btn-primary btn-block">Sign in</button>
        </form>

        <a href="{{ route('home') }}" class="login-back">&larr; Back to website</a>
    </main>

</body>

</html>
