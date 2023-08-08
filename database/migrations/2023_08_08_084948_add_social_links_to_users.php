<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('twitter_url')->nullable()->after('avatar');
            $table->string('github_url')->nullable()->after('avatar');
            $table->string('website_url')->nullable()->after('avatar');
        });
    }
};
