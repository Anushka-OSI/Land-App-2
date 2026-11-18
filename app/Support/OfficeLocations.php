<?php

namespace App\Support;

use App\Models\RegionalOffice;

/**
 * Map locations of the Head Office and the regional offices (set by the admin with the map picker).
 * Used by the homepage office map and the Contact Us pages.
 */
class OfficeLocations
{
    /** Sri Lanka, with a little margin – a location outside this is a mistake. */
    public const BOUNDS = ['lat_min' => 5.7, 'lat_max' => 10.1, 'lng_min' => 79.4, 'lng_max' => 82.1];

    /** Centre and zoom used when there is no location yet. */
    public const CENTER = [7.8731, 80.7718];
    public const ZOOM = 7;

    /** Validation rules for a latitude / longitude pair (both or neither). */
    public static function rules(): array
    {
        return [
            'latitude' => ['nullable', 'required_with:longitude', 'numeric', 'between:' . self::BOUNDS['lat_min'] . ',' . self::BOUNDS['lat_max']],
            'longitude' => ['nullable', 'required_with:latitude', 'numeric', 'between:' . self::BOUNDS['lng_min'] . ',' . self::BOUNDS['lng_max']],
        ];
    }

    public static function messages(): array
    {
        return [
            'latitude.between' => 'The location must be in Sri Lanka. Click the office on the map to set it.',
            'longitude.between' => 'The location must be in Sri Lanka. Click the office on the map to set it.',
            'latitude.required_with' => 'Set both latitude and longitude, or clear the location.',
            'longitude.required_with' => 'Set both latitude and longitude, or clear the location.',
        ];
    }

    /** Round to 7 decimals (about 1 cm) and turn empty values into null. */
    public static function clean(mixed $value): ?float
    {
        return is_numeric($value) ? round((float) $value, 7) : null;
    }

    /**
     * Every published office that has a location, in the visitor's language.
     *
     * @return list<array{type:string, name:string, address:?string, phone:?string, email:?string, lat:float, lng:float, url:string}>
     */
    public static function all(): array
    {
        $offices = [];

        $head = HeadOfficeDetails::location();
        if ($head) {
            $offices[] = [
                'type' => 'head',
                'name' => HeadOfficeDetails::text('name') ?: __('Head Office'),
                'address' => HeadOfficeDetails::text('address'),
                'phone' => HeadOfficeDetails::contact('phone'),
                'email' => HeadOfficeDetails::contact('email'),
                'lat' => $head[0],
                'lng' => $head[1],
                'url' => route('contact.head-office') . '#head-office',
            ];
        }

        foreach (RegionalOffice::published()->whereNotNull('latitude')->whereNotNull('longitude')->get() as $office) {
            $offices[] = [
                'type' => 'regional',
                'name' => $office->textIn('name'),
                'address' => $office->textIn('address'),
                'phone' => $office->phone,
                'email' => $office->email,
                'lat' => (float) $office->latitude,
                'lng' => (float) $office->longitude,
                'url' => route('contact.regional-office') . '#' . $office->anchor(),
            ];
        }

        return $offices;
    }

    /** Google Maps directions to a point (opens the visitor's maps app on phones). */
    public static function directionsUrl(float $lat, float $lng): string
    {
        return 'https://www.google.com/maps/dir/?api=1&destination=' . $lat . ',' . $lng;
    }
}
