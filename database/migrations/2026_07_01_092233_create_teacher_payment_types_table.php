<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('teacher_payment_types', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignId('teacher_id')->constrained('users')->cascadeOnDelete();
            $table->tinyInteger('type')->comment('1=standart_maash, 2=shagird_sayina_gore, 3=faiz_dercesi');
            $table->decimal('amount', 10, 2)->nullable()->comment('standart maaş və ya şagird sayına görə məbləğ');
            $table->decimal('percentage', 5, 2)->nullable()->comment('faiz dərəcəsi');
            $table->foreignUuid('group_id')->nullable()->constrained('groups')->nullOnDelete();
            $table->boolean('status')->default(true);
            $table->softDeletes();
            $table->userstamps();
            $table->userstampSoftDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('teacher_payment_types');
    }
};
