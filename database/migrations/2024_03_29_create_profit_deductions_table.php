<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('profit_deductions', function (Blueprint $table) {
            $table->id();
            $table->decimal('amount', 15, 2);
            $table->text('description')->nullable();
            $table->date('deduction_date');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('profit_deductions');
    }
}; 