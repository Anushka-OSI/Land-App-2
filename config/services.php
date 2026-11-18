<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    // eTitle land records API (Find Land page)
    'etitle' => [
        'base_url' => env('ETITLE_API_URL', 'http://etitle.landsettledept.gov.lk'),
        // Public IP to fall back to when local DNS points the host at an unreachable internal address
        'fallback_ip' => env('ETITLE_API_IP'),
        'timeout' => (int) env('ETITLE_API_TIMEOUT', 20),
        // Path of the "search by NIC" API, with {nic} as placeholder, e.g. get-records-by-nic/{nic}
        'nic_path' => env('ETITLE_NIC_PATH'),
    ],

    // Sri Lankan public holidays and Poya days for the event calendar (iCalendar feed).
    // Leave empty to use the public "Holidays in Sri Lanka" Google calendar.
    'holiday_calendar' => [
        'url' => env('HOLIDAY_CALENDAR_URL'),
    ],

];
