<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rfcs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('url')->nullable();
            $table->text('description')->nullable();
            $table->bigInteger('count_yes')->default(0);
            $table->bigInteger('count_no')->default(0);
            $table->timestamps();
            $table->datetime('published_at')->nullable();
            $table->datetime('ends_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rfcs');
    }
};
