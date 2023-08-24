<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pending_rfcs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug');
            $table->longText('description')->nullable();
            $table->json('authors')->nullable();
            $table->string('status')->nullable();
            $table->string('type')->nullable();
            $table->string('url')->nullable();
            $table->string('version')->nullable();
            $table->string('php_version')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pending_rfcs');
    }
};
