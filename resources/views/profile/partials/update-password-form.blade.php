<section>
    <div class="flex items-center gap-3 mb-6">
        <div class="h-12 w-12 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
            </svg>
        </div>
        <div>
            <h2 class="text-xl font-bold text-gray-900">Update Password</h2>
            <p class="text-sm text-gray-500">Ensure your account is using a long, random password to stay secure</p>
        </div>
    </div>

    <form method="post" action="{{ route('password.update') }}" class="space-y-6">
        @csrf
        @method('put')

        <div class="form-control">
            <label class="label">
                <span class="label-text font-semibold text-gray-900">Current Password</span>
                <span class="label-text-alt text-error">*</span>
            </label>
            <div class="relative">
                <input type="password" id="update_password_current_password" name="current_password"
                    class="input input-bordered w-full" autocomplete="current-password" />
                <div class="absolute right-3 top-1/2 -translate-y-1/2">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                </div>
            </div>
            <x-input-error :messages="$errors->updatePassword->get('current_password')" />
        </div>

        <div class="form-control">
            <label class="label">
                <span class="label-text font-semibold text-gray-900">New Password</span>
                <span class="label-text-alt text-error">*</span>
            </label>
            <div class="relative">
                <input type="password" id="update_password_password" name="password"
                    class="input input-bordered w-full" autocomplete="new-password" />
                <div class="absolute right-3 top-1/2 -translate-y-1/2">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                    </svg>
                </div>
            </div>
            <x-input-error :messages="$errors->updatePassword->get('password')" />
        </div>

        <div class="form-control">
            <label class="label">
                <span class="label-text font-semibold text-gray-900">Confirm Password</span>
                <span class="label-text-alt text-error">*</span>
            </label>
            <div class="relative">
                <input type="password" id="update_password_password_confirmation" name="password_confirmation"
                    class="input input-bordered w-full" autocomplete="new-password" />
                <div class="absolute right-3 top-1/2 -translate-y-1/2">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" />
        </div>

        <div class="flex items-center gap-4 pt-4">
            <button type="submit" class="btn btn-primary gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                {{ __('Save') }}
            </button>

            @if (session('status') === 'password-updated')
                <div
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="alert alert-success py-2 px-4"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="text-sm">{{ __('Saved.') }}</span>
                </div>
            @endif
        </div>
    </form>
</section>
