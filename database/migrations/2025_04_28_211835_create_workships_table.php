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
        Schema::create('workships', function (Blueprint $table) {
            $table->id('id');
            $table->integer('amount');
            $table->text('comment');
            $table->foreignId('user_id')->nullable()
            ->constrained( table: 'users', indexName: 'workships_user_id')
            ->onUpdate('cascade')
            ->onDelete('cascade'); 
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
        Schema::drop('workships');
    }
};
