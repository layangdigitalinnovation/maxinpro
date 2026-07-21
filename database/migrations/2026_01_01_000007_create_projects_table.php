<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->foreignId('developer_id')->constrained()->restrictOnDelete();
            $table->foreignId('area_id')->constrained()->restrictOnDelete();
            $table->text('description')->nullable();
            $table->enum('status', ['Launching', 'Premium', 'New Cluster', 'Sold Out'])->default('Launching');
            $table->unsignedBigInteger('price_from');
            $table->string('units_available')->nullable(); // e.g. "Sisa 12 unit" kept as text per design
            $table->string('cover_image')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->index(['status', 'published_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
