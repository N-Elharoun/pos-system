<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Safe;
use App\Enums\SafeTypeEnum;
use App\Enums\SafeStatusEnum;
use App\Http\Requests\Admin\SafeRequest;

class SafeController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view_safe')->only('index', 'show');
        $this->middleware('permission:create_safe')->only('create', 'store');
        $this->middleware('permission:update_safe')->only('edit', 'update');
        $this->middleware('permission:delete_safe')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $safes = Safe::all();
        return view('admin.safes.index', compact('safes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $safesTypes = SafeTypeEnum::labels();
        $safesStatuses = SafeStatusEnum::labels();
        return view('admin.safes.create', compact('safesTypes', 'safesStatuses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SafeRequest $request)
    {
        $data = $request->validated();
        Safe::create($data);
        return to_route('admin.safes.index')->with('success', 'Safe added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $safe = Safe::findOrFail($id);
        $safeTransactions = $safe->safeTransactions()->paginate(10);
        return view('admin.safes.show', compact('safe', 'safeTransactions'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $safe = Safe::findOrFail($id);
        $safesTypes = SafeTypeEnum::labels();
        $safesStatuses = SafeStatusEnum::labels();
        return view('admin.safes.edit', compact('safe', 'safesStatuses', 'safesTypes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SafeRequest $request, $id)
    {
        $data = $request->validated();
        $safe = Safe::findOrFail($id);
        $safe->update($data);
        return to_route('admin.safes.index')->with('success', 'Safe updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $safe = Safe::findOrFail($id);
        $safe->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Safe deleted successfully'
        ]);
    }
}
