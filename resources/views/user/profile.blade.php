@extends('layouts.user')

@section('content')
    <div class="col-span-9 shadow rounded px-6 pt-5 pb-7">
        <h4 class="text-lg font-medium capitalize mb-4">
            Profile Information
        </h4>
        <form action="{{ route('user.profile.update') }}" method="POST">
            @method('put')
            @csrf
            <div class="space-y-4">
                <!-- Name Field -->
                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <label for="first">Name</label>
                        <input type="text" name="first" id="first" class="input-box"
                            value="{{ old('first', $user->name) }}">
                    </div>
                </div>
                <!-- Email Field -->
                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <label for="email">Email Address</label>
                        <input type="email" name="email" id="email" class="input-box"
                            value="{{ old('email', $user->email) }}">
                    </div>
                </div>
                <!-- Current Password Field -->
                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <label for="current_password">Current Password</label>
                        <input type="password" name="current_password" id="current_password" class="input-box">
                    </div>
                </div>
                <!-- New Password Field -->
                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <label for="new_password">New Password</label>
                        <input type="password" name="new_password" id="new_password" class="input-box">
                    </div>
                </div>
                <!-- Confirm New Password Field -->
                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <label for="new_password_confirmation">Confirm New Password</label>
                        <input type="password" name="new_password_confirmation" id="new_password_confirmation"
                            class="input-box">
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <button type="submit"
                    class="py-3 px-4 text-center text-white bg-primary border border-primary rounded-md hover:bg-transparent hover:text-primary transition font-medium">Save
                    Changes</button>
            </div>
        </form>
    </div>
@endsection
