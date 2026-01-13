<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    protected $fillable = [
        'key',
        'value',
        'type',
        'group',
        'display_name',
        'description',
    ];

    protected $casts = [
        'value' => 'string',
    ];

    /**
     * Get a setting value by key
     */
    public static function get(string $key, $default = null)
    {
        $setting = static::where('key', $key)->first();

        if (!$setting) {
            return $default;
        }

        // Handle null values
        if ($setting->value === null) {
            return $default;
        }

        // Convert boolean strings to actual booleans
        if ($setting->type === 'boolean') {
            return (bool) $setting->value;
        }

        // Convert numeric strings to numbers
        if ($setting->type === 'number') {
            return is_numeric($setting->value) ? floatval($setting->value) : $default;
        }

        return $setting->value;
    }

    /**
     * Set a setting value
     */
    public static function set(string $key, $value): void
    {
        $setting = static::where('key', $key)->first();

        if ($setting) {
            // Convert value to string for storage
            $stringValue = (string) $value;

            // Handle boolean conversion
            if ($setting->type === 'boolean') {
                $stringValue = $value ? '1' : '0';
            }

            $setting->update(['value' => $stringValue]);
        }
    }

    /**
     * Get settings by group
     */
    public static function getByGroup(string $group): \Illuminate\Database\Eloquent\Collection
    {
        return static::where('group', $group)
            ->orderBy('display_name')
            ->get();
    }

    /**
     * Get all settings grouped
     */
    public static function getAllGrouped(): array
    {
        $settings = static::all()->groupBy('group');

        return [
            'general' => $settings->get('general', collect()),
            'attendance' => $settings->get('attendance', collect()),
            'payment' => $settings->get('payment', collect()),
            'notification' => $settings->get('notification', collect()),
        ];
    }

    /**
     * Check if weekly holiday is a specific day
     */
    public static function isWeeklyHoliday(\Carbon\Carbon $date): bool
    {
        $weeklyHolidayDay = static::get('weekly_holiday', 5); // Default: Friday (5)

        // Carbon dayOfWeek: 0=Sunday, 1=Monday, ..., 6=Saturday
        // Settings format: 1=Monday, 2=Tuesday, ..., 7=Sunday
        $carbonDayOfWeek = $date->dayOfWeek === 0 ? 7 : $date->dayOfWeek;

        return $carbonDayOfWeek == $weeklyHolidayDay;
    }

    /**
     * Get weekly holiday day name
     */
    public static function getWeeklyHolidayName(): string
    {
        $day = static::get('weekly_holiday', 5);
        $days = [
            1 => 'Monday',
            2 => 'Tuesday',
            3 => 'Wednesday',
            4 => 'Thursday',
            5 => 'Friday',
            6 => 'Saturday',
            7 => 'Sunday',
        ];

        return $days[$day] ?? 'Friday';
    }

    /**
     * Get formatted currency
     */
    public static function getCurrencySymbol(): string
    {
        return static::get('currency_symbol', '$');
    }

    /**
     * Get default working hours
     */
    public static function getDefaultWorkingHours(): float
    {
        return static::get('default_working_hours', 8);
    }
}
