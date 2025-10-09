<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Unit;
use App\Enums\UnitStatusEnum;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $units = Unit::all();
        return view('admin.units.index', compact('units'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $unitstatuses = UnitStatusEnum::labels();
        return view('admin.units.create', compact('unitstatuses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request = $request->validate([
                'name' => ['required','unique:units'],
                'status' => ['required','in:1,2']
        ]);
        Unit::create($request);
        return to_route('admin.units.index')->with('success', 'Unit added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $unitstatuses = UnitStatusEnum::labels();
        $unit = Unit::findOrFail($id);
        return view('admin.units.edit', compact('unit', 'unitstatuses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $unit = Unit::findOrFail($id);
        $request = $request->validate([
           'name' => 'required|unique:units,name,' . $unit->id,
            'status' => ['required','in:1,2']
        ]);
        $unit->update($request);
        return to_route('admin.units.index')->with('success', 'Unit Updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $unit = Unit::findOrFail($id);
        $unit->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Unit deleted successfully.'
            ]);
    }
}
