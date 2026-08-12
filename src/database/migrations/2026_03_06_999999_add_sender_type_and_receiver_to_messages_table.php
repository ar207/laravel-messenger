<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSenderTypeAndReceiverToMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->string('sender_type')->nullable()->after('sender_id');
            $table->string('receiver_type')->nullable()->after('receiver_id');
            $table->string('delete_user_type')->nullable()->after('delete_user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->dropColumn('sender_type');
            $table->dropColumn('receiver_type');
            $table->dropColumn('delete_user_type');
        });
    }
}
