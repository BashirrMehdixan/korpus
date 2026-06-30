<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('icon')->nullable();
            $table->string('route')->nullable();
            $table->foreignUuid('parent_id')->nullable()->constrained('menus')->cascadeOnDelete();
            $table->unsignedTinyInteger('order')->default(0);
            $table->boolean('status')->default(true);
            $table->timestamps();
            $table->userstamps();
            $table->softDeletes();
            $table->userstampSoftDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
