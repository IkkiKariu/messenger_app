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
        Schema::create('replies', function (Blueprint $table) {
            $table->id();
            //$table->timestamps();
            $table->timestamp('created_at');

            $table->bigInteger('target_id')->unsigned();
            $table->foreign('target_id')->references('id')->on('messages')->onDelete('cascade');

            $table->bigInteger('source_id')->unsigned();
            $table->foreign('source_id')->references('id')->on('messages')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('replies');
    }
};
