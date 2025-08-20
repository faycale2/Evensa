<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('event_requests', function (Blueprint $table) {
            $table->timestamp('published_at')->nullable();
        });
    }

    public function down()
    {
        Schema::table('event_requests', function (Blueprint $table) {
            $table->dropColumn(['published_at']);
        });
    }
};