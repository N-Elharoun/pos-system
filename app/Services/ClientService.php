<?php

namespace App\Services;

use App\Models\Sale;
use App\Models\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ClientService
{
    /**
     * Record a client transaction and update their balance.
     */
    public function recordTransaction(Sale $sale, string $description = null): void
    {
        DB::transaction(function () use ($sale, $description) {
            $net = $sale->net_amount;
            $paid = $sale->paid_amount;
            $balance = $net - $paid;

            // Update client balance
            if ($balance != 0) {
                $sale->client->increment('balance', $balance);
            }

            // Record transaction in client_account_transactions table
            $sale->clientAccountTransaction()->create([
                'user_id'       => Auth::id(),
                'client_id'     => $sale->client_id,
                'credit'        => $net,
                'debit'         => $paid,
                'balance'       => $balance,
                'description'   => $description ?? 'Sale Remaining Amount, Invoice #: ' . $sale->invoice_number,
                'balance_after' => $sale->client->fresh()->balance,
            ]);
        });
    }
}
