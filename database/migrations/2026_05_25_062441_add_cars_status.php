<?php

declare(strict_types=1);

use App\Enums\Car\CarStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('cars', 'status')) {
            Schema::table('cars', function (Blueprint $table) {
                $table->unsignedTinyInteger('status')
                    ->default(CarStatus::IN_STOCK->value)
                    ->after('type');
            });
        }

        if (Schema::hasColumn('cars', 'count')) {
            DB::table('cars')
                ->where('count', '<=', 0)
                ->update(['status' => CarStatus::SOLD->value]);

            Schema::table('cars', function (Blueprint $table) {
                $table->dropColumn('count');
            });
        }
    }

    public function down(): void
    {
        if (! Schema::hasColumn('cars', 'count')) {
            Schema::table('cars', function (Blueprint $table) {
                $table->integer('count')->default(1)->after('type');
            });

            DB::table('cars')
                ->where('status', CarStatus::SOLD->value)
                ->update(['count' => 0]);

            DB::table('cars')
                ->where('status', '!=', CarStatus::SOLD->value)
                ->update(['count' => 1]);
        }

        if (Schema::hasColumn('cars', 'status')) {
            Schema::table('cars', function (Blueprint $table) {
                $table->dropColumn('status');
            });
        }
    }
};
