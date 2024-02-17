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
            $table->string("ticket_number", 40)->nullable(false);
            $table->string("title", 100)->nullable(false);
            $table->text("description")->nullable(false);
            $table->json("label")->nullable(false);
            $table->json("category")->nullable(false);
            $table->string("priority", 20)->nullable();
            $table->string("status", 20)->nullable(false)->default("pending");
            $table->unsignedBigInteger("user_id")->nullable(false);
            $table->foreign("user_id")->references("id")->on("users");
            $table->unsignedBigInteger("engineer_id")->nullable();
            $table->foreign("engineer_id")->references("id")->on("users");
            $table->timestamps();
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
