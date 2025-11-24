<?php

namespace App\Services;

use App\Models\Sale;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ClientService
{
    /**
     * Record a client transaction and update their balance.
     */
    public function inTransaction(Model $reference, string $description = null): void
    {
        DB::transaction(function () use ($reference, $description) {
            $net = $reference->net_amount;
            $paid = $reference->paid_amount;
            $balance = $net - $paid;

            // Update client balance
            if ($balance != 0) {
                $reference->client->increment('balance', $balance);
            }

            // Record transaction in client_account_transactions table
            $reference->clientAccountTransaction()->create([
                'user_id'       => Auth::id(),
                'client_id'     => $reference->client_id,
                'credit'        => $net,
                'debit'         => $paid,
                'balance'       => $balance,
                'description'   => $description ?? 'Sale Remaining Amount, Invoice #: ' . $reference->invoice_number,
                'balance_after' => $reference->client->fresh()->balance,
            ]);
        });
    }
    public function outerTransaction(Model $reference, string $description = null): void
    {
        DB::transaction(function () use ($reference, $description) {
            $net = $reference->net_amount;
            $paid = $reference->paid_amount;
            $balance = $paid - $net;

            // Update client balance
            if ($balance != 0) {
                $reference->client->increment('balance', $balance);
            }

            // Record transaction in client_account_transactions table
            $reference->clientAccountTransaction()->create([
                'user_id'       => Auth::id(),
                'client_id'     => $reference->client_id,
                'credit'        => $paid,
                'debit'         => $net,
                'balance'       => $balance,
                'description'   => $description ?? 'Sale Remaining Amount, Invoice #: ' . $reference->invoice_number,
                'balance_after' => $reference->client->fresh()->balance,
            ]);
        });
    }
    public function adminOutTransaction($client, float $validatedAmount): void
    {
        DB::transaction(function () use ($client, $validatedAmount) {
            $client->decrement('balance', $validatedAmount);
            $client->clientAccountTransactions()->create([
                'user_id'       => Auth::id(),
                'client_id'     => $client->id,
                'credit'        => 0,
                'debit'         => $validatedAmount,
                'balance'       => -$validatedAmount,
                'description'   => 'Update Client Balance by admin ',
                'balance_after' => $client->refresh()->balance,
            ]);
        });
    }
}
