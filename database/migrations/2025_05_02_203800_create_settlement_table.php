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
        Schema::create('settlements', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
            ->constrained( table: 'users', indexName: 'settlement_user_id')
            ->onUpdate('cascade')
            ->onDelete('cascade'); 

            $table->foreignId('quest_id')
            ->constrained( table: 'quests', indexName: 'settlement_quest_id')
            ->onUpdate('cascade')
            ->onDelete('cascade'); 

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settlements');
    }
};
