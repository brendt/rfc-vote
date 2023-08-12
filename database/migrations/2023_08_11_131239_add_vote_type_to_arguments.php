<?php

use App\Models\VoteType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('arguments', function (Blueprint $table) {
            $table->string('vote_type')->after('rfc_id')->default(VoteType::YES->value);
        });
    }
};
