<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('option_sale', function (Blueprint $table) {
            $table->foreignId('option_id')->constrained('options')->cascadeOnDelete();
            $table->foreignId('sail_id')->constrained('sails')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('option_sale');
    }
};
