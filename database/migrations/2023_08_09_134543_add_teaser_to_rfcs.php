<?php

use App\Models\Rfc;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('rfcs', function (Blueprint $table) {
            $table->text('teaser')->after('title')->nullable();
        });

        Rfc::each(fn (Rfc $rfc) => $rfc->update([
            'teaser' => $rfc->description,
        ]));
    }

    public function down(): void
    {
        Schema::table('rfcs', function (Blueprint $table) {
            //
        });
    }
};
