<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\RequiresAllLanguages;
use App\Http\Controllers\Controller;
use App\Models\HeadOfficeDivision;
use Illuminate\Http\Request;

/** Admin → Head Office: divisions and officers shown on Contact Us → Head Office. */
class HeadOfficeDivisionController extends Controller
{
    use RequiresAllLanguages;

    public function index(Request $request)
    {
        $divisions = HeadOfficeDivision::query()
            ->when($request->filled('q'), fn ($q) => $q->where(function ($q) use ($request) {
                $term = '%' . $request->q . '%';
                $q->where('division', 'like', $term)
                    ->orWhere('position', 'like', $term)
                    ->orWhere('officer', 'like', $term)
                    ->orWhere('email', 'like', $term);
            }))
            ->ordered()
            ->get();

        return view('admin.head-office.index', compact('divisions'));
    }

    public function create()
    {
        return view('admin.head-office.form', ['item' => new HeadOfficeDivision([
            'sort_order' => (int) HeadOfficeDivision::max('sort_order') + 10,
            'is_published' => true,
        ])]);
    }

    public function store(Request $request)
    {
        HeadOfficeDivision::create($this->validated($request));

        return redirect()->route('admin.head-office.index')->with('success', 'Division added.');
    }

    public function edit(HeadOfficeDivision $head_office)
    {
        return view('admin.head-office.form', ['item' => $head_office]);
    }

    public function update(Request $request, HeadOfficeDivision $head_office)
    {
        $head_office->update($this->validated($request));

        return redirect()->route('admin.head-office.index')->with('success', 'Division updated.');
    }

    public function destroy(HeadOfficeDivision $head_office)
    {
        $head_office->delete();

        return redirect()->route('admin.head-office.index')->with('success', 'Division deleted.');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'division'    => 'nullable|string|max:255',
            'division_si' => 'nullable|string|max:255',
            'division_ta' => 'nullable|string|max:255',
            'position'    => 'nullable|string|max:255',
            'position_si' => 'nullable|string|max:255',
            'position_ta' => 'nullable|string|max:255',
            'officer'     => 'nullable|string|max:255',
            'phone'       => 'nullable|string|max:50',
            'fax'         => 'nullable|string|max:50',
            'extension'   => 'nullable|string|max:20',
            'email'       => 'nullable|email|max:255',
            'sort_order'  => 'required|integer|min:0|max:100000',
        ], [], [
            'division' => 'division / section name',
            'sort_order' => 'display order',
        ]);

        $this->checkAllLanguages($data, [
            'Division / section name' => self::englishBaseColumns('division'),
        ], [
            'Position' => self::englishBaseColumns('position'),
        ]);

        $data['is_published'] = $request->boolean('is_published');

        return $data;
    }
}
