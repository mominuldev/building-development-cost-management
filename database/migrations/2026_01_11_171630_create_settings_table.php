<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->string('type')->default('text'); // text, number, boolean, json
            $table->string('group')->default('general'); // general, attendance, payment, notification
            $table->string('display_name');
            $table->text('description')->nullable();
            $table->timestamps();

            $table->index('group');
            $table->index('key');
        });

        // Insert default settings
        DB::table('settings')->insert([
            [
                'key' => 'company_name',
                'value' => 'My Construction Company',
                'type' => 'text',
                'group' => 'general',
                'display_name' => 'Company Name',
                'description' => 'Your company or organization name',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'company_address',
                'value' => null,
                'type' => 'text',
                'group' => 'general',
                'display_name' => 'Company Address',
                'description' => 'Your company address for invoices and reports',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'company_phone',
                'value' => null,
                'type' => 'text',
                'group' => 'general',
                'display_name' => 'Company Phone',
                'description' => 'Contact phone number',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'company_email',
                'value' => null,
                'type' => 'text',
                'group' => 'general',
                'display_name' => 'Company Email',
                'description' => 'Contact email address',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'default_currency',
                'value' => 'USD',
                'type' => 'text',
                'group' => 'general',
                'display_name' => 'Default Currency',
                'description' => 'Default currency for all projects (USD, EUR, GBP, BDT, etc.)',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'currency_symbol',
                'value' => '$',
                'type' => 'text',
                'group' => 'general',
                'display_name' => 'Currency Symbol',
                'description' => 'Symbol to display before amounts ($, €, £, ৳, etc.)',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'weekly_holiday',
                'value' => '5',
                'type' => 'number',
                'group' => 'attendance',
                'display_name' => 'Weekly Holiday',
                'description' => 'Day of week for weekly holiday (1=Monday, 5=Friday, 7=Sunday)',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'default_working_hours',
                'value' => '8',
                'type' => 'number',
                'group' => 'attendance',
                'display_name' => 'Default Working Hours',
                'description' => 'Standard working hours per day',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'overtime_rate_multiplier',
                'value' => '1.5',
                'type' => 'number',
                'group' => 'attendance',
                'display_name' => 'Overtime Rate Multiplier',
                'description' => 'Multiplier for overtime wage calculation (e.g., 1.5 = 150%)',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'payment_terms',
                'value' => 'Net 30',
                'type' => 'text',
                'group' => 'payment',
                'display_name' => 'Default Payment Terms',
                'description' => 'Default payment terms for contracts (e.g., Net 30, Net 15)',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'tax_rate',
                'value' => '0',
                'type' => 'number',
                'group' => 'payment',
                'display_name' => 'Default Tax Rate (%)',
                'description' => 'Default tax rate for calculations (enter as percentage, e.g., 10 for 10%)',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'enable_email_notifications',
                'value' => '1',
                'type' => 'boolean',
                'group' => 'notification',
                'display_name' => 'Enable Email Notifications',
                'description' => 'Send email notifications for important events',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'payment_reminder_days',
                'value' => '7',
                'type' => 'number',
                'group' => 'notification',
                'display_name' => 'Payment Reminder (Days Before)',
                'description' => 'Send payment reminders N days before due date',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
