<?php

use App\Models\Rfc;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Rfc::each(fn (Rfc $rfc) => $rfc->updateVoteCount());
    }
};
