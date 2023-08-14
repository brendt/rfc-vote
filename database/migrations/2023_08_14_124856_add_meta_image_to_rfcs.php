<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rfcs', function () {
            DB::statement('ALTER TABLE rfcs ADD `meta_image` MEDIUMBLOB');
        });
    }
};
