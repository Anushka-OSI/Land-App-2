@extends('layouts.admin')

@section('title', 'My Account')

@section('content')

    <div class="profile-grid">
        <form method="POST" action="{{ route('admin.profile.update') }}" class="panel form-panel" novalidate>
            @csrf
            @method('PUT')
            <h3 class="panel-subtitle">Profile</h3>

            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}"
                    class="form-input @error('name') is-invalid @enderror">
                @error('name') <small class="form-error">{{ $message }}</small> @enderror
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}"
                    class="form-input @error('email') is-invalid @enderror">
                @error('email') <small class="form-error">{{ $message }}</small> @enderror
            </div>

            <button type="submit" class="btn btn-primary">Save Profile</button>
        </form>

        <form method="POST" action="{{ route('admin.profile.password') }}" class="panel form-panel" novalidate>
            @csrf
            @method('PUT')
            <h3 class="panel-subtitle">Change Password</h3>

            <div class="form-group">
                <label for="current_password">Current password</label>
                <input type="password" id="current_password" name="current_password" autocomplete="current-password"
                    class="form-input @error('current_password') is-invalid @enderror">
                @error('current_password') <small class="form-error">{{ $message }}</small> @enderror
            </div>

            <div class="form-group">
                <label for="password">New password <span class="hint">(min 8 characters)</span></label>
                <input type="password" id="password" name="password" autocomplete="new-password"
                    class="form-input @error('password') is-invalid @enderror">
                @error('password') <small class="form-error">{{ $message }}</small> @enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirm new password</label>
                <input type="password" id="password_confirmation" name="password_confirmation"
                    autocomplete="new-password" class="form-input">
            </div>

            <button type="submit" class="btn btn-primary">Change Password</button>
        </form>
    </div>

    @if($user->last_login_at)
        <p class="muted">Last login: {{ $user->last_login_at->format('M j, Y g:i A') }}</p>
    @endif

@endsection
