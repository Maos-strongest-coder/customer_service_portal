<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->enum('status', ['open', 'started', 'closed'])->default('open');
            $table->foreignId('issued_by_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('issued_to_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->timestamps();
            $table->index(['issued_by_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
