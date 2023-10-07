<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('chat_details', function (Blueprint $table) {
            $table->text('input')->change();
            $table->text('output')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('chat_details', function (Blueprint $table) {
            $table->string('input')->change();
            $table->string('output')->change();
        });
    }
};
