<?php

use App\Enums\Car\CarColor;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cars', function (Blueprint $table) {
            DB::statement('ALTER TABLE cars DROP CONSTRAINT IF EXISTS cars_color_check');
            $table->string('color')->change();
        });
    }

    public function down(): void
    {
        Schema::table('cars', function (Blueprint $table) {
            DB::statement('ALTER TABLE cars DROP CONSTRAINT IF EXISTS cars_color_check');
            $cases = collect(CarColor::cases())->map(fn ($c) => "'{$c->value}'")->implode(', ');
            DB::statement('ALTER TABLE cars ALTER COLUMN color TYPE VARCHAR(255)');
            DB::statement("ALTER TABLE cars ADD CONSTRAINT cars_color_check CHECK (color IN ($cases))");
        });
    }
};
