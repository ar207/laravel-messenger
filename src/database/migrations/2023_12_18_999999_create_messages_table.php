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
        Schema::create('messages', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('sender_id')->nullable();
            $table->bigInteger('receiver_id')->nullable();
            $table->bigInteger('chat_id')->nullable();
            $table->text('message')->nullable();
            $table->string('file')->nullable();
            $table->string('file_type')->nullable();
            $table->string('file_size')->nullable();
            $table->string('file_original_name')->nullable();
            $table->tinyInteger('is_seen')->default(0);
            $table->tinyInteger('deleted_from_sender')->default(0);
            $table->tinyInteger('deleted_from_receiver')->default(0);
            $table->bigInteger('is_reply')->nullable();
            $table->bigInteger('delete_user_id')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
