<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('don_legs', function (Blueprint $table) {
            $table->id('id');
            $table->string('type');
            $table->integer('amount');
            $table->foreignId('user_id')->nullable()
            ->constrained( table: 'users', indexName: 'don_legs_user_id')
            ->onUpdate('cascade')
            ->onDelete('cascade'); 
            $table->timestamp('dated_at')->nullable()->useCurrent();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('don_legs');
    }
};
