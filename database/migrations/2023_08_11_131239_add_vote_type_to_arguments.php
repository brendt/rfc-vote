<?php

use App\Models\Argument;
use App\Models\Rfc;
use App\Models\VoteType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('arguments', function (Blueprint $table) {
            $table->string('vote_type')->after('rfc_id')->default(VoteType::YES->value);
        });

        Argument::each(function (Argument $argument) {
            $vote = $argument->user->getVoteForRfc($argument->rfc);

            if (! $vote) {
                return;
            }

            $argument->update([
                'vote_type' => $vote->type,
            ]);
        });

        Rfc::each(fn (Rfc $rfc) => $rfc->updateVoteCount());
    }
};
