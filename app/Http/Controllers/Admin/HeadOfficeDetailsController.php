<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\RequiresAllLanguages;
use App\Http\Controllers\Controller;
use App\Support\HeadOfficeDetails;
use App\Support\Languages;
use App\Support\OfficeLocations;
use Illuminate\Http\Request;

/** Admin → Head Office → Office details: name, address, phone, fax, email and office hours. */
class HeadOfficeDetailsController extends Controller
{
    use RequiresAllLanguages;

    public function edit()
    {
        return view('admin.head-office.details', ['details' => HeadOfficeDetails::all()]);
    }

    public function update(Request $request)
    {
        $rules = [
            'phone' => 'nullable|string|max:50',
            'fax'   => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
        ];
        $names = [];
        foreach (Languages::ALL as $lang => $info) {
            $rules["name_{$lang}"] = 'nullable|string|max:255';
            $rules["address_{$lang}"] = 'nullable|string|max:500';
            $rules["hours_{$lang}"] = 'nullable|string|max:500';
            $names += [
                "name_{$lang}" => "{$info['label']} office name",
                "address_{$lang}" => "{$info['label']} address",
                "hours_{$lang}" => "{$info['label']} office hours",
            ];
        }

        $data = $request->validate($rules + OfficeLocations::rules(), OfficeLocations::messages(), $names);

        $this->checkAllLanguages($data, [
            'Office name' => self::suffixedColumns('name'),
            'Address' => self::suffixedColumns('address'),
        ], [
            'Office hours' => self::suffixedColumns('hours'),
        ]);

        $data['latitude'] = OfficeLocations::clean($data['latitude'] ?? null);
        $data['longitude'] = OfficeLocations::clean($data['longitude'] ?? null);

        HeadOfficeDetails::save($data);

        return redirect()->route('admin.head-office.index')->with('success', 'Head Office details saved.');
    }
}
