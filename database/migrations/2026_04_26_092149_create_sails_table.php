<?php

use App\Enums\Sail\SailStatus;
use App\Enums\Sail\SailType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sails', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('car_id')->nullable();
            $table->integer('price')->nullable();
            $table->enum('status', SailStatus::cases())->default(SailStatus::PENDING);
            $table->enum('type', SailType::cases());
            $table->timestamps();

            $table->foreign('client_id')
                ->references('id')
                ->on('clients')
                ->onDelete('set null');

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('set null');

            $table->foreign('car_id')
                ->references('id')
                ->on('cars')
                ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sails');
    }
};
