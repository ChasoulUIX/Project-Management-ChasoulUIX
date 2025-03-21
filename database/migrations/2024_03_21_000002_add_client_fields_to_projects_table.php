<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->foreignId('client_id')->nullable()->constrained()->onDelete('set null');
            $table->decimal('client_budget', 15, 2)->nullable();
            $table->text('client_requirements')->nullable();
            $table->timestamp('client_deadline')->nullable();
            $table->text('revision_notes')->nullable();
            $table->integer('revision_count')->default(0);
            $table->timestamp('last_revision')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropForeign(['client_id']);
            $table->dropColumn([
                'client_id',
                'client_budget',
                'client_requirements',
                'client_deadline',
                'revision_notes',
                'revision_count',
                'last_revision'
            ]);
        });
    }
}; 