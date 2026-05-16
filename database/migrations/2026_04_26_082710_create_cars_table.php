<?php

use App\Enums\Car\CarColor;
use App\Enums\Car\CarType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->string('mark')->index('idx_car_mark');
            $table->string('model')->index('idx_car_model');
            $table->string('class')->nullable()->index('idx_car_class');
            $table->string('vin_code');
            $table->integer('year');
            $table->integer('price');
            $table->enum('color', CarColor::cases());
            $table->enum('type', CarType::cases());
            $table->integer('count')->default(1);
            $table->string('state_number')->nullable();
            $table->string('preview')->nullable();
            $table->json('images')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
