

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_xx_xx_create_event_requests_table.php
    public function up()
    {
        Schema::create('event_requests', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->text('description');
            $table->string('lieu');
            $table->dateTime('dates');
            $table->enum('statut', ['draft','pending','waiting_director ', 'director_approved ', 'commission_validated ','rejected']);
            $table->foreignId('instance_id')->constrained('instances')->onDelete('cascade');
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            //$table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_requests');
    }
};
