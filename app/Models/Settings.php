<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Settings extends Model
{
    use HasFactory;

    protected $fillable = ['key', 'cast', 'value'];

    protected static function booted()
    {
        parent::booted();

        // Clear cache and reload settings when a setting is saved or updated
        static::saved(function () {
            Cache::forget('app_settings'); // Clear the cached settings

            // Immediately re-cache the settings
            Cache::remember('app_settings', now()->addMonths(3), function () {
                return Settings::get()->pluck('value', 'key')->toArray(); // Cache as an associative array
            });
        });

        // Clear cache when a setting is deleted
        static::deleted(function () {
            Cache::forget('app_settings'); // Clear the cached settings
            Cache::remember('app_settings', now()->addMonths(3), function () {
                return Settings::get()->pluck('value', 'key')->toArray(); // Cache as an associative array
            });
        });
    }

    /**
     * Get the value attribute dynamically casted based on the cast column.
     */
    public function getValueAttribute($value)
    {
        return match ($this->cast) {
            'json' => json_decode($value, true),
            'integer' => (int) $value,
            'boolean' => filter_var($value, FILTER_VALIDATE_BOOLEAN),
            'float' => (float) $value,
            'array' => json_decode($value, true),
            default => $value, // Default: Return as a string
        };
    }

    /**
     * Set the value attribute and store the detected cast type.
     */
    public function setValueAttribute($value)
    {
        $type = gettype($value);

        // Detect type dynamically and store the cast type
        $this->attributes['cast'] = match ($type) {
            'array', 'object' => 'json',
            'integer' => 'integer',
            'boolean' => 'boolean',
            'double' => 'float',
            default => 'string',
        };

        // Convert the value based on type
        $this->attributes['value'] = match ($this->attributes['cast']) {
            'json' => json_encode($value),
            'boolean' => $value ? 'true' : 'false',
            default => (string) $value,
        };
    }
}
