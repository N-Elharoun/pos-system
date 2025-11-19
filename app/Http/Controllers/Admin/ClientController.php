<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ClientService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Client;
use App\Models\ClientAccountTransaction;
use App\Enums\ClientRegistrationEnum;
use App\Enums\ClientStatusEnum;
use App\Http\Requests\Admin\ClientRequest;

class ClientController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view_client')->only('index', 'show');
        $this->middleware('permission:create_client')->only('create', 'store');
        $this->middleware('permission:update_client')->only('edit', 'update');
        $this->middleware('permission:delete_client')->only('destroy');
    }
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
        DB::beginTransaction();
        $client = Client::create($request->validated());
        $client->clientAccountTransactions()->create([
            'user_id'       => Auth::id(),
            'client_id'     => $client->id,
            'credit'        => 0,
            'debit'         => 0,
            'balance'       => 0,
            'balance_after' => 0,
            'description'   => 'Initial Balance',
        ]);
        DB::commit();
        return to_route('admin.clients.index')->with('success', 'Client added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $client = Client::findOrFail($id);
        $transactions = ClientAccountTransaction::with('user')->where('client_id', $id)->get();
        return view('admin.clients.show', compact('client', 'transactions'));
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
    public function balance($id)
    {
        $client = Client::findOrFail($id);
        return view('admin.clients.balance', compact('client'));
    }
    public function updateBalance(Request $request, $id)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:1',
        ]);
        $amount = $validated['amount'];
        $client = Client::findOrFail($id);
        (new ClientService())->outTransaction($client, $amount);
        return to_route('admin.clients.index')->with('success', 'Client`s Balance updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $client = Client::findOrFail($id);
        if ($client->sales()->exists()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Cannot delete client with associated sales.',
            ]);
        }
        $client->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Client deleted successfully.'
        ]);
    }
}
