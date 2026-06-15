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
        Schema::create('claim_guides', function (Blueprint $table) {
            $table->id();
            $table->string('institution');
            $table->string('title');
            $table->text('description');
            $table->json('steps')->nullable();
            $table->json('documents_required')->nullable();
            $table->string('estimated_time')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('claim_guides');
    }
};
