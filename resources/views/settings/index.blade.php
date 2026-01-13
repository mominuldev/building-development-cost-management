<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Settings</h2>
                <p class="text-gray-500 mt-1">Manage your application preferences</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if(session('success'))
                <div class="alert alert-success">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <form action="{{ route('settings.update') }}" method="POST">
                @csrf
                @method('PUT')

                <!-- General Settings -->
                <div class="card bg-white shadow-xl">
                    <div class="card-body">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="h-10 w-10 rounded-lg bg-gradient-to-br from-blue-500 to-indigo-500 flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-900">General Settings</h3>
                                <p class="text-sm text-gray-500">Company information and currency</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="form-control md:col-span-2">
                                <label class="label">
                                    <span class="label-text font-semibold text-gray-900">Company Name</span>
                                </label>
                                <input type="text" name="company_name" value="{{ old('company_name', \App\Models\Settings::get('company_name')) }}"
                                    placeholder="My Construction Company"
                                    class="input input-bordered" />
                                <label class="label">
                                    <span class="label-text-alt">{{ $settings['general']->firstWhere('key', 'company_name')->description }}</span>
                                </label>
                            </div>

                            <div class="form-control md:col-span-2">
                                <label class="label">
                                    <span class="label-text font-semibold text-gray-900">Company Address</span>
                                </label>
                                <textarea name="company_address" rows="2"
                                    placeholder="Street address, city, state, postal code..."
                                    class="textarea textarea-bordered">{{ old('company_address', \App\Models\Settings::get('company_address')) }}</textarea>
                            </div>

                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text font-semibold text-gray-900">Company Phone</span>
                                </label>
                                <input type="text" name="company_phone" value="{{ old('company_phone', \App\Models\Settings::get('company_phone')) }}"
                                    placeholder="+1 234 567 8900"
                                    class="input input-bordered" />
                            </div>

                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text font-semibold text-gray-900">Company Email</span>
                                </label>
                                <input type="email" name="company_email" value="{{ old('company_email', \App\Models\Settings::get('company_email')) }}"
                                    placeholder="info@company.com"
                                    class="input input-bordered" />
                            </div>

                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text font-semibold text-gray-900">Default Currency</span>
                                </label>
                                <select name="default_currency" class="select select-bordered">
                                    <option value="USD" {{ old('default_currency', \App\Models\Settings::get('default_currency')) === 'USD' ? 'selected' : '' }}>USD - US Dollar</option>
                                    <option value="EUR" {{ old('default_currency', \App\Models\Settings::get('default_currency')) === 'EUR' ? 'selected' : '' }}>EUR - Euro</option>
                                    <option value="GBP" {{ old('default_currency', \App\Models\Settings::get('default_currency')) === 'GBP' ? 'selected' : '' }}>GBP - British Pound</option>
                                    <option value="BDT" {{ old('default_currency', \App\Models\Settings::get('default_currency')) === 'BDT' ? 'selected' : '' }}>BDT - Bangladeshi Taka</option>
                                    <option value="INR" {{ old('default_currency', \App\Models\Settings::get('default_currency')) === 'INR' ? 'selected' : '' }}>INR - Indian Rupee</option>
                                    <option value="PKR" {{ old('default_currency', \App\Models\Settings::get('default_currency')) === 'PKR' ? 'selected' : '' }}>PKR - Pakistani Rupee</option>
                                    <option value="AUD" {{ old('default_currency', \App\Models\Settings::get('default_currency')) === 'AUD' ? 'selected' : '' }}>AUD - Australian Dollar</option>
                                    <option value="CAD" {{ old('default_currency', \App\Models\Settings::get('default_currency')) === 'CAD' ? 'selected' : '' }}>CAD - Canadian Dollar</option>
                                </select>
                            </div>

                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text font-semibold text-gray-900">Currency Symbol</span>
                                </label>
                                <input type="text" name="currency_symbol" value="{{ old('currency_symbol', \App\Models\Settings::get('currency_symbol')) }}"
                                    placeholder="$"
                                    class="input input-bordered w-20" />
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Attendance Settings -->
                <div class="card bg-white shadow-xl">
                    <div class="card-body">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="h-10 w-10 rounded-lg bg-gradient-to-br from-green-500 to-emerald-500 flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-900">Attendance Settings</h3>
                                <p class="text-sm text-gray-500">Working hours and holidays</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text font-semibold text-gray-900">Weekly Holiday</span>
                                </label>
                                <select name="weekly_holiday" class="select select-bordered">
                                    <option value="1" {{ old('weekly_holiday', \App\Models\Settings::get('weekly_holiday')) == 1 ? 'selected' : '' }}>Monday</option>
                                    <option value="2" {{ old('weekly_holiday', \App\Models\Settings::get('weekly_holiday')) == 2 ? 'selected' : '' }}>Tuesday</option>
                                    <option value="3" {{ old('weekly_holiday', \App\Models\Settings::get('weekly_holiday')) == 3 ? 'selected' : '' }}>Wednesday</option>
                                    <option value="4" {{ old('weekly_holiday', \App\Models\Settings::get('weekly_holiday')) == 4 ? 'selected' : '' }}>Thursday</option>
                                    <option value="5" {{ old('weekly_holiday', \App\Models\Settings::get('weekly_holiday')) == 5 ? 'selected' : '' }}>Friday</option>
                                    <option value="6" {{ old('weekly_holiday', \App\Models\Settings::get('weekly_holiday')) == 6 ? 'selected' : '' }}>Saturday</option>
                                    <option value="7" {{ old('weekly_holiday', \App\Models\Settings::get('weekly_holiday')) == 7 ? 'selected' : '' }}>Sunday</option>
                                </select>
                                <label class="label">
                                    <span class="label-text-alt">Currently set to: <strong>{{ \App\Models\Settings::getWeeklyHolidayName() }}</strong></span>
                                </label>
                            </div>

                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text font-semibold text-gray-900">Default Working Hours</span>
                                </label>
                                <div class="relative">
                                    <input type="number" name="default_working_hours" value="{{ old('default_working_hours', \App\Models\Settings::get('default_working_hours')) }}"
                                        step="0.5" min="0" max="24"
                                        class="input input-bordered" />
                                    <div class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm">hrs/day</div>
                                </div>
                            </div>

                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text font-semibold text-gray-900">Overtime Multiplier</span>
                                </label>
                                <div class="relative">
                                    <input type="number" name="overtime_rate_multiplier" value="{{ old('overtime_rate_multiplier', \App\Models\Settings::get('overtime_rate_multiplier')) }}"
                                        step="0.1" min="0" max="10"
                                        class="input input-bordered" />
                                    <div class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm">× rate</div>
                                </div>
                                <label class="label">
                                    <span class="label-text-alt">1.5 = 150% of daily wage</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment Settings -->
                <div class="card bg-white shadow-xl">
                    <div class="card-body">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="h-10 w-10 rounded-lg bg-gradient-to-br from-purple-500 to-pink-500 flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-900">Payment Settings</h3>
                                <p class="text-sm text-gray-500">Payment terms and tax configuration</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="form-control md:col-span-2">
                                <label class="label">
                                    <span class="label-text font-semibold text-gray-900">Default Payment Terms</span>
                                </label>
                                <input type="text" name="payment_terms" value="{{ old('payment_terms', \App\Models\Settings::get('payment_terms')) }}"
                                    placeholder="Net 30"
                                    class="input input-bordered" />
                                <label class="label">
                                    <span class="label-text-alt">e.g., Net 30, Net 15, Due on Receipt</span>
                                </label>
                            </div>

                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text font-semibold text-gray-900">Default Tax Rate (%)</span>
                                </label>
                                <div class="relative">
                                    <input type="number" name="tax_rate" value="{{ old('tax_rate', \App\Models\Settings::get('tax_rate')) }}"
                                        step="0.01" min="0" max="100"
                                        class="input input-bordered pr-8" />
                                    <div class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400">%</div>
                                </div>
                                <label class="label">
                                    <span class="label-text-alt">Enter 0 for no tax</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Notification Settings -->
                <div class="card bg-white shadow-xl">
                    <div class="card-body">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="h-10 w-10 rounded-lg bg-gradient-to-br from-amber-500 to-orange-500 flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-900">Notification Settings</h3>
                                <p class="text-sm text-gray-500">Email and reminder preferences</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="form-control">
                                <label class="label cursor-pointer">
                                    <span class="label-text font-semibold text-gray-900">Enable Email Notifications</span>
                                    <input type="checkbox" name="enable_email_notifications" class="checkbox checkbox-primary" {{ old('enable_email_notifications', \App\Models\Settings::get('enable_email_notifications')) ? 'checked' : '' }} value="1">
                                </label>
                                <label class="label">
                                    <span class="label-text-alt">{{ $settings['notification']->firstWhere('key', 'enable_email_notifications')->description }}</span>
                                </label>
                            </div>

                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text font-semibold text-gray-900">Payment Reminder Days</span>
                                </label>
                                <div class="relative">
                                    <input type="number" name="payment_reminder_days" value="{{ old('payment_reminder_days', \App\Models\Settings::get('payment_reminder_days')) }}"
                                        min="0" max="365"
                                        class="input input-bordered" />
                                    <div class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm">days before</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex justify-end gap-3">
                    <a href="{{ url()->previous() ?: route('projects.index') }}" class="btn btn-ghost gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Cancel
                    </a>
                    <button type="submit" class="btn btn-primary gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Save Settings
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
