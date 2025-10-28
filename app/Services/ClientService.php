<?php

namespace App\Services;
use App\Models\ClientAccountTransaction;
use App\Enums\SafeTransactionTypeEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ClientService
{