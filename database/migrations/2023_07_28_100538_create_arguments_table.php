<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('arguments', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedBigInteger('vote_id');
            $table->foreign('vote_id')->references('id')->on('votes')->onDelete('cascade');

            $table->string('type');
            $table->longText('body')->nullable();

            $table->unsignedInteger('vote_count')->default(0);
            $table->boolean('is_highlighted')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('arguments');
    }
};
