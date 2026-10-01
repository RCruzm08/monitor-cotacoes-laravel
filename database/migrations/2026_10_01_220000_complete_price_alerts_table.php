<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('price_alerts', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnDelete();
            $table->foreignId('asset_id')->nullable()->constrained('assets')->cascadeOnDelete();
            $table->decimal('target_price', 12, 4)->default(0);
            $table->enum('condition', ['above', 'below'])->default('above');
            $table->boolean('is_triggered')->default(false);
            $table->timestamp('triggered_at')->nullable();
            $table->index(['asset_id', 'is_triggered']);
            $table->index(['user_id', 'is_triggered']);
        });
    }

    public function down(): void
    {
        Schema::table('price_alerts', function (Blueprint $table) {
            $table->dropIndex(['asset_id', 'is_triggered']);
            $table->dropIndex(['user_id', 'is_triggered']);
            $table->dropConstrainedForeignId('user_id');
            $table->dropConstrainedForeignId('asset_id');
            $table->dropColumn(['target_price', 'condition', 'is_triggered', 'triggered_at']);
        });
    }
};
