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
    public function outTransaction(Model $reference, float $validatedAmount): void
    {
        DB::transaction(function () use ($reference, $validatedAmount) {
            $balance = $reference->client->balance;
            $reference->client()->decrement('balance', $validatedAmount);
            $reference->clientAccountTransaction()->create([
                'user_id'       => Auth::id(),
                'client_id'     => $reference->client_id,
                'credit'        => 0,
                'debit'         => $validatedAmount,
                'balance'       => $balance,
                'description'   => 'Sale Paying Remaining Amount, Invoice #: ' . $reference->invoice_number,
                'balance_after' => $reference->client->fresh()->balance,
            ]);
        });
    }
}
