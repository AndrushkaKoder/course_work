<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('credit_applications') && Schema::hasColumn('credit_applications', 'manager_id')) {
            Schema::table('credit_applications', function (Blueprint $table) {
                $table->dropForeign(['manager_id']);
            });

            Schema::table('credit_applications', function (Blueprint $table) {
                $table->renameColumn('manager_id', 'user_id');
            });

            Schema::table('credit_applications', function (Blueprint $table) {
                $table->foreign('user_id')
                    ->references('id')
                    ->on('users')
                    ->nullOnDelete();
            });
        } elseif (Schema::hasTable('credit_applications') && Schema::hasColumn('credit_applications', 'user_id')) {
            Schema::table('credit_applications', function (Blueprint $table) {
                $table->dropForeign(['user_id']);
            });

            Schema::table('credit_applications', function (Blueprint $table) {
                $table->foreign('user_id')
                    ->references('id')
                    ->on('users')
                    ->nullOnDelete();
            });
        }

        if (Schema::hasTable('sails') && Schema::hasColumn('sails', 'user_id')) {
            Schema::table('sails', function (Blueprint $table) {
                $table->dropForeign(['user_id']);
            });

            Schema::table('sails', function (Blueprint $table) {
                $table->foreign('user_id')
                    ->references('id')
                    ->on('users')
                    ->nullOnDelete();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('credit_applications') && Schema::hasColumn('credit_applications', 'user_id')) {
            Schema::table('credit_applications', function (Blueprint $table) {
                $table->dropForeign(['user_id']);
            });

            Schema::table('credit_applications', function (Blueprint $table) {
                $table->renameColumn('user_id', 'manager_id');
            });

            Schema::table('credit_applications', function (Blueprint $table) {
                $table->foreign('manager_id')
                    ->references('id')
                    ->on('moonshine_users')
                    ->nullOnDelete();
            });
        }

        if (Schema::hasTable('sails') && Schema::hasColumn('sails', 'user_id')) {
            Schema::table('sails', function (Blueprint $table) {
                $table->dropForeign(['user_id']);
            });

            Schema::table('sails', function (Blueprint $table) {
                $table->foreign('user_id')
                    ->references('id')
                    ->on('moonshine_users')
                    ->nullOnDelete();
            });
        }
    }
};
