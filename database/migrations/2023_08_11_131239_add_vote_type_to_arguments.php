<?php

use App\Models\Argument;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('arguments', function (Blueprint $table) {
            $table->string('vote_type')->nullable()->after('rfc_id');
        });

        Argument::each(function (Argument $argument) {
            $vote = $argument->user->getVoteForRfc($argument->rfc);

            return $argument->update([
                'vote_type' => $vote->type,
            ]);
        });
    }
};
