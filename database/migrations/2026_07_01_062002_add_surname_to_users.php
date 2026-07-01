<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('surname')->nullable();
            $table->string('patronymic')->nullable();
            $table->string('phone')->nullable();
            $table->dateTime('registration_date')->nullable();
            $table->softDeletes();
            $table->userstamps();
            $table->userstampSoftDeletes();
            $table->boolean('status')->default(true);
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['surname', 'patronymic', 'phone', 'registration_date', 'status', 'created_by', 'updated_by', 'deleted_at', 'deleted_by']);
        });
    }
};
