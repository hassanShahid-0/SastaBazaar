<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('complaints', function (Blueprint $table) {
            // Nullable so existing anonymous complaints remain untouched
            $table->foreignId('citizen_id')
                  ->nullable()
                  ->after('id')
                  ->constrained('citizens')
                  ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('complaints', function (Blueprint $table) {
            $table->dropForeignIdFor(\App\Models\Citizen::class);
            $table->dropColumn('citizen_id');
        });
    }
};
