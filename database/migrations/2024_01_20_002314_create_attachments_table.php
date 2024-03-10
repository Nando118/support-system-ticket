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
        Schema::create('attachments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("ticket_id")->nullable(true);
            $table->foreign("ticket_id")->references("id")->on("tickets");
            $table->unsignedBigInteger("comment_id")->nullable(true);
            $table->foreign("comment_id")->references("id")->on("comments");
            $table->string("file_name", 200)->nullable(false);
            $table->string("file_path", 200)->nullable(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attachments');
    }
};
