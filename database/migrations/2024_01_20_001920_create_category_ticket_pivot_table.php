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
        Schema::create('category_ticket_pivot', function (Blueprint $table) {
            $table->unsignedBigInteger("ticket_id")->nullable(false);
            $table->unsignedBigInteger("category_id")->nullable(false);
            $table->primary(["ticket_id", "category_id"]);
            $table->foreign("ticket_id")->references("id")->on("tickets");
            $table->foreign("category_id")->references("id")->on("categories");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('category_ticket_pivot');
    }
};
