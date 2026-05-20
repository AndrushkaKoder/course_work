<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('credit_applications', function (Blueprint $table) {
            if (! Schema::hasColumn('credit_applications', 'user_id')
                && ! Schema::hasColumn('credit_applications', 'manager_id')) {
                $table->unsignedBigInteger('user_id')->nullable()->after('client_id');
                $table->foreign('user_id')
                    ->references('id')
                    ->on('users')
                    ->nullOnDelete();
            }

            if (! Schema::hasColumn('credit_applications', 'sum')) {
                $after = Schema::hasColumn('credit_applications', 'user_id') ? 'user_id' : 'manager_id';
                $table->integer('sum')->default(0)->after($after);
            }
        });
    }

    public function down(): void
    {
        Schema::table('credit_applications', function (Blueprint $table) {
            if (Schema::hasColumn('credit_applications', 'user_id')
                && ! Schema::hasColumn('credit_applications', 'manager_id')) {
                $table->dropForeign(['user_id']);
                $table->dropColumn('user_id');
            }

            if (Schema::hasColumn('credit_applications', 'sum')) {
                $table->dropColumn('sum');
            }
        });
    }
};
