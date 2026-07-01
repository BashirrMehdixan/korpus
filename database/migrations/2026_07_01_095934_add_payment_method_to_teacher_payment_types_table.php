<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('teacher_payment_types', function (Blueprint $table) {
            $table->tinyInteger('payment_method')->nullable()->after('type')->comment('1=birdəfəlik, 2=aylıq');
        });
    }

    public function down(): void
    {
        Schema::table('teacher_payment_types', function (Blueprint $table) {
            $table->dropColumn('payment_method');
        });
    }
};
