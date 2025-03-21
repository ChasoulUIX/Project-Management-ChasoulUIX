<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('whatsapp');
            $table->text('address')->nullable();
            $table->text('notes')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->string('company_name')->nullable();
            $table->string('position')->nullable();
            $table->string('website')->nullable();
            $table->string('instagram')->nullable();
            $table->string('source')->nullable();
            $table->string('profile_image')->nullable();
            $table->timestamp('last_contact')->nullable();
            $table->timestamp('last_project')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
}; 