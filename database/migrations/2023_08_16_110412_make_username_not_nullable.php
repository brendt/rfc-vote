<?php

use App\Actions\GenerateUsername;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // As we are about to enforce all users to have a username, we need to make sure we generate one for all that do not have a one yet.
        User::whereNull(['username'])->each(fn(User $user) => $user->update(
            [
                'username' => (new GenerateUsername)($user),
            ]
        ));

        Schema::table('users', function (Blueprint $table) {
            $table->string('username')->nullable(false)->change();
        });
    }
    public function down():void {
        Schema::table('users', function (Blueprint $table) {
            $table->string('username')->nullable()->change();
        });
    }
};
