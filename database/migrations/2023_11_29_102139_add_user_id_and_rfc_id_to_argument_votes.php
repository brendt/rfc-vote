<?php

use App\Models\ArgumentVote;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('argument_votes', function (Blueprint $table) {
            $table->unsignedBigInteger('argument_user_id')->nullable()->after('argument_id');
            $table->foreign('argument_user_id')->references('id')->on('users');

            $table->unsignedBigInteger('argument_rfc_id')->nullable()->after('argument_id');
            $table->foreign('argument_rfc_id')->references('id')->on('rfcs');
        });

        ArgumentVote::each(fn (ArgumentVote $vote) => $vote->save());
    }

    public function down(): void
    {
        Schema::table('argument_votes', function (Blueprint $table) {
            //
        });
    }
};
