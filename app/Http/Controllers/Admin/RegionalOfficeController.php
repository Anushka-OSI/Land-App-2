<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\RequiresAllLanguages;
use App\Http\Controllers\Controller;
use App\Models\RegionalOffice;
use App\Support\OfficeLocations;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

/** Admin → Regional Offices: district offices shown on Contact Us → Regional Offices. */
class RegionalOfficeController extends Controller
{
    use RequiresAllLanguages;

    public function index(Request $request)
    {
        $offices = RegionalOffice::query()
            ->when($request->filled('q'), fn ($q) => $q->where(function ($q) use ($request) {
                $term = '%' . $request->q . '%';
                $q->where('name', 'like', $term)
                    ->orWhere('address', 'like', $term)
                    ->orWhere('phone', 'like', $term)
                    ->orWhere('email', 'like', $term);
            }))
            ->when(array_key_exists((string) $request->province, RegionalOffice::PROVINCES),
                fn ($q) => $q->where('province', $request->province))
            ->ordered()
            ->get();

        return view('admin.regional-offices.index', compact('offices'));
    }

    public function create(Request $request)
    {
        $province = array_key_exists((string) $request->province, RegionalOffice::PROVINCES)
            ? $request->province
            : array_key_first(RegionalOffice::PROVINCES);

        return view('admin.regional-offices.form', ['item' => new RegionalOffice([
            'province' => $province,
            'sort_order' => (int) RegionalOffice::max('sort_order') + 10,
            'is_published' => true,
        ])]);
    }

    public function store(Request $request)
    {
        RegionalOffice::create($this->validated($request));

        return redirect()->route('admin.regional-offices.index')->with('success', 'Regional office added.');
    }

    public function edit(RegionalOffice $regional_office)
    {
        return view('admin.regional-offices.form', ['item' => $regional_office]);
    }

    public function update(Request $request, RegionalOffice $regional_office)
    {
        $regional_office->update($this->validated($request));

        return redirect()->route('admin.regional-offices.index')->with('success', 'Regional office updated.');
    }

    public function destroy(RegionalOffice $regional_office)
    {
        $regional_office->delete();

        return redirect()->route('admin.regional-offices.index')->with('success', 'Regional office deleted.');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'province'   => ['required', Rule::in(array_keys(RegionalOffice::PROVINCES))],
            'name'       => 'nullable|string|max:255',
            'name_si'    => 'nullable|string|max:255',
            'name_ta'    => 'nullable|string|max:255',
            'address'    => 'nullable|string|max:500',
            'address_si' => 'nullable|string|max:500',
            'address_ta' => 'nullable|string|max:500',
            'phone'      => 'nullable|string|max:50',
            'email'      => 'nullable|email|max:255',
            'sort_order' => 'required|integer|min:0|max:100000',
        ] + OfficeLocations::rules(), OfficeLocations::messages(), [
            'name' => 'office name',
            'sort_order' => 'display order',
        ]);

        $this->checkAllLanguages($data, [
            'Office name' => self::englishBaseColumns('name'),
        ], [
            'Address' => self::englishBaseColumns('address'),
        ]);

        $data['latitude'] = OfficeLocations::clean($data['latitude'] ?? null);
        $data['longitude'] = OfficeLocations::clean($data['longitude'] ?? null);
        $data['is_published'] = $request->boolean('is_published');

        return $data;
    }
}
