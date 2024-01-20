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
        Schema::create('label_ticket_pivot', function (Blueprint $table) {
            $table->unsignedBigInteger("ticket_id")->nullable(false);
            $table->unsignedBigInteger("label_id")->nullable(false);
            $table->primary(["ticket_id", "label_id"]);
            $table->foreign("ticket_id")->references("id")->on("tickets");
            $table->foreign("label_id")->references("id")->on("labels");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('label_ticket_pivot');
    }
};
