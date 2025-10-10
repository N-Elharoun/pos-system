<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Enums\ClientRegistrationEnum;
use App\Enums\ClientStatusEnum;
use App\Http\Requests\Admin\ClientRequest;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clients = Client::paginate(10);
        return view('admin.clients.index', compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clientStatus = ClientStatusEnum::labels();
        $clientRegistration = ClientRegistrationEnum::labels();
        return view('admin.clients.create', compact('clientStatus', 'clientRegistration'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ClientRequest $request)
    {
        Client::create($request->validated());
        return to_route('admin.clients.index')->with('success', 'Client added successfully!');
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
        $clientStatus = ClientStatusEnum::labels();
        $clientRegistration = ClientRegistrationEnum::labels();
        $client = Client::findOrFail($id);
        return view('admin.clients.edit', compact('client', 'clientRegistration', 'clientStatus'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ClientRequest $request, string $id)
    {
        $client = Client::findOrFail($id);
        $client->update($request->validated());
        return to_route('admin.clients.index')->with('success', 'Client updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $client = Client::findOrFail($id);
        $client->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Client deleted successfully.'
        ]);
    }
}
